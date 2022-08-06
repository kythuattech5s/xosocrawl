<?php
namespace crawlmodule\basecrawler\Crawlers;

use App\Models\Forum;
use App\Models\User;
use basiccomment\comment\Models\Comment;

class CommentCrawler extends BaseCrawler
{
    public function startCrawl()
    {
        $listForumCrawl = Forum::act()->where('is_crawl',1)->get();
        foreach ($listForumCrawl as $itemForumCrawl) {
            $this->crawlCommentForum($itemForumCrawl);
        }
        return true;
    }
    public function crawlCommentForum($itemForumCrawl)
    {
        $countItem = 0;
        $listComment = $this->exeCurl($itemForumCrawl->crawl_comment_link);
        $arrCommentCrawl = \Support::extractJson($listComment);
        while (count($arrCommentCrawl) > 0 && isset($arrCommentCrawl['data']) && isset($arrCommentCrawl['data']['comments']) && $countItem < 500) {
            $status = $this->saveComment($arrCommentCrawl['data']['comments'],$itemForumCrawl);
            $countItem += count($arrCommentCrawl['data']['comments']);
            if (!$status) {
                return;
            }
            $listComment = $this->exeCurl($itemForumCrawl->crawl_comment_link.'&min_id='.(end($arrCommentCrawl['data']['comments'])['id'] ?? 100000000000));
            $arrCommentCrawl = \Support::extractJson($listComment);
        }
    }
    public function saveComment($arrComments,$itemForumCrawl)
    {
        foreach ($arrComments as $itemComment) {
            $userId = $itemComment['auth_id'] ?? 0;
            if ($userId >= 500000 || $userId < 1 || trim($itemComment['content']) == '') continue;
            try {
                $oldComment = Comment::where('crawl_id',$itemComment['id'])->first();
                if (isset($oldComment)) {
                    return false;
                }
                $user = $oldUser = User::find($itemComment['auth_id'] ?? 0);
                if (!isset($oldUser)) {
                    $newUser = new User;
                    $newUser->id = $userId;
                    $newUser->fullname = $itemComment['auth_name'] ?? '';
                    $newUser->act = 1;
                    $newUser->banned = 0;
                    $newUser->is_fake_user = 1;
                    $newUser->is_social_account = \Str::contains($itemComment['auth_image'] ?? '','http') ? 1:0;
                    if ($newUser->is_social_account == 1) {
                        $newUser->use_image_social = 1;
                        $newUser->image_social = $itemComment['auth_image'];
                    }else{
                        if ($itemComment['auth_image'] == '' || \Str::contains($itemComment['auth_image'],'default_avatar.gif')) {
                            $newUser->img = '';
                        }else{
                            $imgLink = 'https://xoso.me/'.$itemComment['auth_image'];
                            $imgLink = str_replace('--60x60','',$imgLink);
                            $newUser->img = $this->saveImg($imgLink,'users/'.$newUser->id.'/avatar');
                        }
                    }
                    $newUser->save();
                    $user = $newUser;
                }
                $newComment = new Comment;
                $newComment->user_id = $user->id;
                $newComment->name = $user->fullname;
                $newComment->map_table = 'forums';
                $newComment->parent = 0;
                $newComment->content = $itemComment['content'];
                $newComment->map_id = $itemForumCrawl->id;
                $newComment->referrer = $itemForumCrawl->slug;
                $newComment->act = 1;
                $newComment->level = 1;
                $newComment->count_child = 0;
                $newComment->count_like = 0;
                $newComment->is_crawl = 1;
                $newComment->crawl_id = $itemComment['id'];
                $newComment->timecreate = $itemComment['time'];
                $newComment->created_at = now()->createFromTimestamp($newComment->timecreate);
                $newComment->updated_at = now()->createFromTimestamp($newComment->timecreate);
                $newComment->save();
            } catch (\Throwable $th) {
                continue;
            }
        }
        return true;
    }
}
