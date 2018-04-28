<?php

use App\ForumCategory;
use App\Forum;
use App\ForumPermission;
use App\ForumPost;
use App\ForumTopic;
use App\ForumTag;
use App\Group;
use Illuminate\Database\Seeder;

class ForumsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run(): void
    {
        $this->seedForumPermissions([
            'show_forum',
            'read_topic',
            'reply_topic',
            'start_topic'
        ]);

        $this->seedForumTags([
            'approved',
            'denied',
            'solved',
            'invalid',
            'bug',
            'suggestion',
            'implemented'
        ]);

        $this->seedForumCategory([
            'name' => $name = 'UNIT3D Forums',
            'slug' => str_slug($name),
            'description' => $name
        ]);

        $this->seedForum([
            'name' => $name = 'Introductions',
            'slug' => str_slug($name),
            'description' => 'Introduce Yourself Here!',
            'forum_category_id' => 1,
        ]);

        $this->seedForumTopic([
            'name' => $name = 'Hello, welcome to the Introductions Forum',
            'slug' => str_slug($name),
            'forum_id' => 1,
            'user_id' => 1,
            'pinned' => true
        ]);

        $this->seedForumPost([
            'forum_topic_id' => 1,
            'user_id' => 1,
            'body' => 'So what is this post for exactly? Well its here merely as an example. You can delete it if you would like to!'
        ]);

        $this->attachPermissionsToGroups();

        // Lets just add a tag to be sure its working
        ForumTopic::find(1)->tags()->attach(1);
    }

    /**
     * PRIVATE METHODS
     */

    private function seedForumPermissions($permissions): void
    {
        foreach ($permissions as $permission) {
            ForumPermission::create([
                'name' => $permission
            ]);
        }
    }

    private function seedForumTags(array $tags): void
    {
        foreach ($tags as $tag) {
            ForumTag::create([
                'name' => $tag
            ]);
        }
    }

    private function seedForumCategory(array $data): void
    {
        ForumCategory::create($data);
    }

    private function seedForum(array $data): void
    {
        Forum::create($data);
    }

    private function seedForumTopic(array $data): void
    {
        ForumTopic::create($data);
    }

    private function seedForumPost($data): void
    {
        ForumPost::create($data);
    }

    private function attachPermissionsToGroups(): void
    {
        $exceptions = [1, 2, 4, 18, 19, 22];

        $permissions = ForumPermission::all()
            ->pluck('id')
            ->toArray();

        foreach (Group::all() as $group) {
            if (!in_array($group->id, $exceptions)) {
                $group->permissions()->attach($permissions);
            }
        }
    }
}
