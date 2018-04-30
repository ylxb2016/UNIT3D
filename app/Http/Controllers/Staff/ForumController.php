<?php
/**
 * NOTICE OF LICENSE
 *
 * UNIT3D is open-sourced software licensed under the GNU General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 * @author     Poppabear 04/2018
 */

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

use App\ForumCategory;
use App\ForumPermission;
use App\ForumPost;
use App\ForumTopic;
use App\Forum;

class ForumController extends Controller
{

    /**
     * @var AuthManager
     */
    private $auth;

    /**
     * @var Forum
     */
    private $forum;

    /**
     * @var ForumCategory
     */
    private $category;

    /**
     * @var ForumPermission
     */
    private $permission;

    /**
     * @var ForumTopic
     */
    private $topic;

    /**
     * @var ForumPost
     */
    private $post;


    public function __construct(
        AuthManager $auth,
        Forum $forum,
        ForumCategory $category,
        ForumPermission $permission,
        ForumTopic $topic,
        ForumPost $post
    )
    {
        $this->auth = $auth;
        $this->forum = $forum;
        $this->category = $category;
        $this->permission = $permission;
        $this->topic = $topic;
        $this->post = $post;
    }

    public function index()
    {
        return view('Staff.forum.index');
    }

    public function create(Request $request)
    {

    }


    public function update(Request $request, $id)
    {

    }


    public function delete($id)
    {

    }
}
