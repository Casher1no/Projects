<?php

namespace App\Controller;

use App\View;
use App\Database;
use App\Model\Friend;

class FriendsController
{
    public function show(array $vars): View
    {
        $userFriends = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('friends')
            ->where("user_id = ? and user_id in (select friend_id from friends where user_id)")
            ->setParameter(0, (int) $vars['id'])
            ->fetchAllAssociative();

        // Invite list
        $userInvites = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('friends')
            ->where("friend_id = ?")
            ->setParameter(0, (int) $vars['id'])
            ->fetchAllAssociative();

        $friendsId = [];
        $inviteId = [];
        foreach ($userFriends as $friend) {
            foreach ($userInvites as $invite) {
                if ($friend['user_id'] == $invite['friend_id'] && $invite['user_id'] == $friend['friend_id']) {
                    $friendsId[] = $friend['friend_id'];
                }
                if ($invite['user_id'] != $friend["friend_id"]) {
                    $inviteId[] = $invite['user_id'];
                }
            }
        }

        $inviteId = array_unique(array_diff($inviteId, $friendsId));
        $friendList = [];
        foreach ($friendsId as $id) {
            $friend = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('user_profiles')
            ->where("user_id = ?")
            ->setParameter(0, $id)
            ->fetchAllAssociative();
            $friendList[] = new Friend(
                $friend[0]['name'],
                $friend[0]['surname'],
                (int)$friend[0]['user_id']
            );
        }
        $inviteList = [];
        foreach ($inviteId as $id) {
            $invite = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('user_profiles')
            ->where("user_id = ?")
            ->setParameter(0, $id)
            ->fetchAllAssociative();
            $inviteList[] = new Friend(
                $invite[0]['name'],
                $invite[0]['surname'],
                (int)$invite[0]['user_id']
            );
        }





        return new View("Users/friends", [
            "friends" => $friendList,
            "invites" => $inviteList
        ]);
    }
}
