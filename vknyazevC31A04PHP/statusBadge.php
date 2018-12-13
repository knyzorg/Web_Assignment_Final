<?php
$statuses = ["To Do", "In Development", "In Test", "Complete"];
function status_to_badge(int $status) : string
{
    $text = "Uknown Status";
    $class = "dark";
    switch ($status) {
        case 1:
            $text = "To do";
            $class = "success";
            break;

        case 2:
            $text = "In Development";
            $class = "primary";
            break;
        case 3:
            $text = "In Test";
            $class = "warning";
            break;
        case 4:
            $text = "Complete";
            $class = "danger";
            break;
    }
    return "<span class='badge badge-$class'>$text</span>";
}