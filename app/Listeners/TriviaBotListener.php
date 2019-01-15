<?php
/**
 * NOTICE OF LICENSE
 *
 * UNIT3D is open-sourced software licensed under the GNU General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 * @author     HDVinnie
 */

namespace App\Listeners;

use App\Game;
use Exception;
use App\Player;
use App\Bots\TriviaBot;
use App\Events\MessageSent;

class TriviaBotListener
{
    /**
     * @param MessageSent $event
     */
    public function handle(MessageSent $event)
    {
        if ($event->message->chatroom_id == config('chat.trivia_chatroom')) {
            $bot = new TriviaBot();
            $game = Game::first();
            if (!$game) {
                try {
                    $game = Game::create(["started" => 0, "stopping" => 0, "delay" => 20, 'last_asked' => 0]);
                } catch (Exception $e) {
                    $bot->sendMessageToChannel($e->getMessage());
                }
            }
            $player_id = $event->message->user_id;
            $player_name = $event->message->user->username;
            $player_text = $event->message->message;
            $player_channel = 2;
            $timestamp = time();
            $player = Player::where('user_id', '=', $player_id)->first();
            if (!$player) {
                try {
                    $player = Player::create([
                        "user_id" => $player_id,
                    ]);
                } catch (Exception $e) {
                    $bot->sendMessageToChannel($e->getMessage());
                }
            }
            $player->user_id = $player_id;
            $player->last_seen = $timestamp;
            $player->save();

            $bot->setChannel($player_channel);

            //each word is a token for the command
            $command = explode(" ", $player_text);

            //commands start with !trivia
            if ($command[0] == "!trivia")
            {
                switch ($command[1]) {
                    case "load":
                        if (!$command[2]) {
                            $bot->sendMessageToChannel(":interrobang: You forgot to tell me what file to load, silly!");
                        } elseif (!$command[3] || $command[3] == "false") {
                            $loaded = $bot->load($command[2]);
                            $bot->sendMessageToChannel($loaded);
                        } else {
                            $loaded = $bot->load($command[2], true);
                            $bot->sendMessageToChannel($loaded);
                        }
                        break;
                    case "start":
                        //start the bot
                        if (!$bot->started()) {
                            $bot->start();
                            $bot->sendMessageToChannel(":sunglasses: Thanks {$player_name}, I was getting bored! More trivia coming up!");
                        } else {
                            $bot->sendMessageToChannel(":stuck_out_tongue_winking_eye: Pay attention {$player_name}, we're already playing trivia!");
                        }
                        break;
                    case "stop":
                        if (!$bot->started()) {
                            $bot->sendMessageToChannel(":stuck_out_tongue_winking_eye: We're not even playing trivia {$player_name}! (Type *!trivia start* if you want to play)");
                        } else {
                            $question = $bot->getCurrentQuestion();
                            $event->message = ":rotating_light: Game stopped by [b]{$player_name}[/b]";
                            if (!$question || $question->current_hint == 1) {
                                $game->started = 0;
                                $game->stopping = 0;
                                $game->save();
                            } else {
                                $event->message .= " _but I've started so I'll finish..._";
                                $bot->stop();
                            }
                            $bot->sendMessageToChannel($event->message);
                        }
                        break;
                    case "delay":
                        {
                            if (!$command[2] || !is_numeric($command[2])) {
                                $bot->sendMessageToChannel(":interrobang: You forgot to tell me how long to set the delay!");
                            } else {
                                if (($command[2] > 20)) {
                                    $game->delay = $command[2];
                                    $delay = $command[2];
                                } else {
                                    $game->delay = 20;
                                    $delay = 20;
                                }
                                $game->save();
                                $bot->sendMessageToChannel("Delay set to {$delay} seconds between hints.");
                            }

                        }
                    case "questions":
                        $total = number_format($bot->get_total_questions());
                        $bot->sendMessageToChannel("[b]{$player_name}[/b]: there are [b]{$total}[/b] questions loaded in the database.");
                        break;
                    case "seen":
                        if (!$command[2]) {
                            $bot->sendMessageToChannel(" :interrobang: You forgot to tell me who you're looking for!");
                        } else {
                            $seen_name = trim($command[2]);
                            $seen_player = Player::find('first', ['name' => $seen_name]);
                            $now = time();
                            if (!$seen_player) {
                                $event->message = "Sorry, {$player_name}, I've never seen {$seen_name}!";
                            } else {
                                $diff = number_format($now - $seen_player->last_seen);
                                $event->message = "Hey {$player_name}, I last saw {$seen_name} [b]{$diff}[/b] seconds ago!";
                            }
                            $bot->sendMessageToChannel($event->message);


                        }
                        break;
                    case "scores":
                        $event->message = "The top 3 high scores are:\n";
                        $scorers = Player::orderBy('high_score', 'DESC')->take(3)->get();

                        if ($scorers) {
                            foreach ($scorers as $scorer) {
                                $score = number_format($scorer->high_score);
                                $event->message .= "[b]{$scorer->user->username}[/b] : {$score}\n";
                            }
                        }
                        $bot->sendMessageToChannel($event->message);
                        break;
                    case "rows": //the only reason this is here is because I always forget it's runs and type rows in channel!
                    case "runs":
                        $event->message = "The top 3 best runs (questions answered in a row before another player) are:\n";
                        $scorers = Player::orderBy('best_run', 'DESC')->take(3)->get();
                        if ($scorers) {
                            foreach ($scorers as $scorer) {
                                $runs = number_format($scorer->best_run);
                                $event->message .= "[b]{$scorer->user->username}[/b] : {$runs}\n";
                            }
                        }
                        $bot->sendMessageToChannel($event->message);
                        break;
                    case "answers":
                        $event->message = "The top 3 players by number of questions answered are:\n";
                        $scorers = Player::orderBy('questions_answered', 'DESC')->take(3)->get();
                        if ($scorers) {
                            foreach ($scorers as $scorer) {
                                $runs = number_format($scorer->questions_answered);
                                $event->message .= "[b]{$scorer->user->username}[/b] : {$runs}\n";
                            }
                        }
                        $bot->sendMessageToChannel($event->message);
                        break;
                    case "me":
                        $months = ["Never", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                        $month = $months[$player->playing_month];
                        $event->message = "Information for [b]{$player_name}[/b]:\n";
                        $event->message .= "Current score (played in {$month}): [b]" . number_format($player->current_score) . "[/b]\n";
                        $event->message .= "High score: [b]" . number_format($player->high_score) . "[/b]\n";
                        $event->message .= "Most questions answered in a row: [b]" . number_format($player->best_run) . "[/b]\n";
                        $event->message .= "Total number of questions answered: [b]" . number_format($player->questions_answered) . "[/b]\n";
                        $bot->sendMessageToChannel(":ok_hand: " . $event->message);
                        break;
                    case "help":
                        //send the help text to the channel
                        $helpText = "The options available are...\n";
                        $helpText .= "*!trivia start / !trivia stop* - starts or stops the game.\n";
                        $helpText .= "*!trivia delay [n]* - set the minimum time between hints in seconds.\n";

                        $helpText .= "*!trivia scores / !trivia runs* - shows the top 3 high scorers / best runs.\n";
                        $helpText .= "*!trivia questions* - shows how many questions are loaded\n";
                        $helpText .= "*!trivia answers* - shows the top 3 players by questions answered\n";
                        $helpText .= "*!trivia me* - get details on your own scoring.\n";
                        $helpText .= "*!trivia seen [player]* - says when the player last typed something in channel\n";
                        $bot->sendMessageToChannel($helpText);
                        break;

                }
            } else {
                if ($bot->started()) {
                    //check if the answer is correct
                    $question = $bot->getCurrentQuestion();
                    if ($question->current_hint == 1) //the question's not been asked yet!
                    {
                        die();
                    }
                    $answers = unserialize($question->answer);
                    $win = false;
                    foreach ($answers as $answer) {
                        $bad_escaped = ["&amp;", "&lt;", "&gt;"];
                        $good_unescaped = ["&", "<", ">"];
                        $lowanswer = strtolower($answer);
                        $lowguess = str_replace($bad_escaped, $good_unescaped, strtolower($player_text));
                        if (trim($lowanswer) == trim($lowguess)) {
                            $win = true;
                        }
                    }
                    if ($win) {
                        //this player's right!!
                        $others = Player::where('id', '!=', $player->id)->get();
                        if ($others) {
                            foreach ($others as $other) {
                                $other->current_run = 0;
                                $other->save();
                            }
                        }

                        $score = 50 - ($question->current_hint * 10);
                        if ($player->playing_month != $game->round_month) {
                            $player->current_score = 0;
                            $player->playing_month = date("n");
                        }
                        $player->current_score += $score;
                        if ($player->current_score > $player->high_score) {
                            $player->high_score = $player->current_score;
                        }
                        $player->current_run++;
                        if ($player->current_run > $player->best_run) {
                            $player->best_run = $player->current_run;
                        }
                        $player->questions_answered++;
                        $player->save();
                        $totalscore = number_format($player->current_score);
                        $event->message = "YES! [b]{$player_name}[/b] that's {$player->current_run} in a row. You scored {$score} points bringing your total for the month to {$totalscore}!\n";
                        $event->message .= "The answer was [b]{$player_text}[/b]!\n";
                        $game->questions_without_reply = 0;
                        if (($game->stopping == 1)) {
                            $question->current_hint = 0;
                            $question->save();
                            $game->started = 0;
                            $game->stopping = 0;
                            $event->message .= "[b]GAME STOPPED[/b]";
                        } else {
                            $event->message .= "Next question coming up...";
                            $bot->start();
                        }
                        $game->save();
                        $bot->sendMessageToChannel(":clap: " . $event->message);
                    }
                }
            }
        }
    }
}