<?php


namespace application\core;


class view
{
    function generate($content_view, $template_view, $data = null)
    {
        include 'application/views/'.$template_view;
    }
}