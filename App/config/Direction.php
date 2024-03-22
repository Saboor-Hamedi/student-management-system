<?php

class Direction
{
    public static function include_path($header)
    {
         
         require_once  "../public/include/$header" . ".php";
    }
   
}
