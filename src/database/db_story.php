<?php
    include_once('../includes/database.php');

    function getUserStories($user_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM post WHERE post_op = ? AND post_title IS NOT NULL');
        $stmt->execute(array($user_id));
        return $stmt->fetchAll();
    }

    function getAllStories($order = "post_date", $asc_desc = "DESC")
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare("SELECT * FROM post WHERE post_title IS NOT NULL ORDER BY $order $asc_desc");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getAllStoriesByVotes()
    {
        $db = Database::instance()->db();
        // $stmt = $db->prepare("SELECT post.* from 
        //                     post,
        //                     (   SELECT post_id, SUM(vote) AS sum FROM vote
        //                         GROUP BY post_id
        //                         ORDER BY sum DESC
        //                     ) as votes 
        //                     where post.post_id = votes.post_id and post.post_title IS NOT NULL");
        $stmt = $db->prepare("SELECT * FROM 
                            post JOIN (SELECT vote.post_id, SUM(vote.vote) AS num_votes
                                FROM vote GROUP BY vote.post_id UNION 
                                SELECT post_id, 0 FROM post 
                                WHERE post_id NOT IN (SELECT post_id FROM vote)) 
                            USING(post_id) WHERE post_title IS NOT NULL ORDER BY num_votes DESC, post_date DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getChannelStories($channel, $order = "post_date", $asc_desc = "DESC")
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare("SELECT * FROM post WHERE channel_id = ? AND post_title IS NOT NULL ORDER BY $order $asc_desc");
        $stmt->execute(array($channel));
        return $stmt->fetchAll();
    }

    function getStory($story_id)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM post WHERE post_id = ? AND post_title IS NOT NULL');
        $stmt->execute(array($story_id));
        return $stmt->fetch();
    }

    function searchStories($pattern)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM post WHERE post_title IS NOT NULL AND post_title LIKE ? OR post_text LIKE ?');
        $stmt->execute(array("%$pattern%", "%$pattern%"));
        return $stmt->fetchAll();
    }

   /**
   * Inserts a new story into the database.
   */
    function insertStory($story_title, $story_text, $img_id, $user_id, $channel_id, $tags)
    {
        $db = Database::instance()->db();
        $stmt = $db->prepare("INSERT INTO post VALUES(NULL, ?, ?, datetime('now'), ?, ?, NULL, ?)");
        $stmt->execute(array($story_title, $story_text, $img_id, $user_id,  $channel_id));

        if($tags){
            $stmt = $db->prepare("SELECT MAX(post_id) AS last_post FROM post");
            $stmt->execute();
            $id = $stmt->fetch()['last_post'];

            foreach($tags as $tag){
                $stmt = $db->prepare("INSERT INTO post_tag VALUES(?, ?)");
                $stmt->execute(array($id, $tag));
            }
        }

        $stmt = $db->prepare('SELECT MAX(post_id) AS post_id FROM post');
        $stmt->execute();

        return $stmt->fetch()['post_id'];
    }

    function getUpvotedStories($user_id){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM post WHERE post_title IS NOT NULL AND post_op <> ? AND post_id IN (SELECT post_title FROM vote WHERE user_id = ?)');
        $stmt->execute(array($user_id, $user_id));
        return $stmt->fetchAll();
    }

    function searchStoriesByTags($tags){

        $inQuery = implode(',', array_fill(0, count($tags), '?'));

        $db = Database::instance()->db();
        $stmt = $db->prepare("SELECT * FROM post WHERE post_id IN (SELECT post_id FROM post_tag WHERE tag_id IN (SELECT tag_id FROM tag WHERE tag_text IN ($inQuery)))");
        $stmt->execute($tags);
        return $stmt->fetchAll();
    }

