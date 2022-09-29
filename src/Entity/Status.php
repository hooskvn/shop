<?php 

namespace App\Entity;

enum Status: string
{
    case Validate = "VALIDATE";
    case InProgess = "IN_PROGRESS";
    case Empty = "EMPTY";
}