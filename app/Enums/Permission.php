<?php

namespace App\Enums;

enum Permission: string
{
    case LIST_TASK = "list-task";
    case CREATE_TASK = "create-task";
    case RETRIEVE_TASK = "retrieve-task";
    case EDIT_TASK = "edit-task";
    case DELETE_TASK = "delete-task";
}
