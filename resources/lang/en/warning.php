<?php
/**
 * Created by PhpStorm.
 * User: bento
 * Date: 8/13/16
 * Time: 7:34 PM
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Warning Language
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default warning messages used by
    | the controller, flash or javascript when user do some actions such as edit
    | delete, deactivate, approve, cancel, closing document and others.
    |
    */

    'delete' => [
        'title' => 'Are you sure you want to deactivate selected item(s) ?',
        'text'  => 'You will be able to undo your action later!',
        'confirm' => [
            'yes' => 'Yes, delete!',
            'no'  => 'No, cancel deleting please!'
        ],
        'isConfirm' => [
            'title' => 'Deleted!',
            'text'  => 'Your data has been deleted.'
        ],
        'isError'   => 'Error happened when trying to deactivate item(s)'
    ],
    'remove' => [
        'title' => 'Are you sure you want to permanently delete selected item(s) ?',
        'text'  => 'You cannot undo your action!',
        'confirm' => [
            'yes' => 'Yes, delete permanently!',
            'no'  => 'No, cancel this action please!'
        ],
        'isConfirm' => [
            'title' => 'Permanently Deleted!',
            'text'  => 'Your delete request has been processed. Some data cannot be deleted when already used.'
        ],
        'isError'   => 'Error happened when trying to permanently delete item(s)'
    ],
    'restore' => [
        'title' => 'Are you sure you want to activate selected item(s) ?',
        'text'  => 'You will be able to undo your action later!',
        'confirm' => [
            'yes' => 'Yes, activate!',
            'no'  => 'No, cancel activating please!'
        ],
        'isConfirm' => [
            'title' => 'Activated!',
            'text'  => 'Your data has been activated.'
        ],
        'isError'   => 'Error happened when trying to activate item(s)'
    ],
    'post' => [
        'title' => 'Are you sure you want to post selected item(s) ?',
        'text'  => 'You cannot undo your action later!',
        'confirm' => [
            'yes' => 'Yes, Post seleted item(s)!',
            'no'  => 'No, cancel post please!'
        ],
        'isConfirm' => [
            'title' => 'Posted!',
            'text'  => 'Your data has been posted.'
        ],
        'isError'   => 'Error happened when trying to post item(s)'
    ],
    'action' => [
        'isCancel'  => [
            'title' => 'Cancelled',
            'text'  => 'Your action has been cancelled :)'
        ],
    ],
    'import' => [
        'isLoadingError' => 'Error happened when previewing import data',
        'isError' => 'Error happened when importing data'
    ],
    'reject' => [
        'title' => 'Are you sure you want to reject selected item(s) ?',
        'text'  => 'You will be able to undo your action later!',
        'confirm' => [
            'yes' => 'Yes, rejected!',
            'no'  => 'No, cancel rejected please!'
        ],
        'isConfirm' => [
            'title' => 'Rejected!',
            'text'  => 'Your data has been rejected.'
        ],
        'isError'   => 'Error happened when trying to rejected item(s)'
    ],
    'approve' => [
        'title' => 'Are you sure you want to approve selected item(s) ?',
        'text'  => 'You will be able to undo your action later!',
        'confirm' => [
            'yes' => 'Yes, approved!',
            'no'  => 'No, cancel approved please!'
        ],
        'isConfirm' => [
            'title' => 'Approved!',
            'text'  => 'Your data has been approved.'
        ],
        'isError'   => 'Error happened when trying to approved item(s)'
    ],

];