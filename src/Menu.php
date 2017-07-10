<?php
namespace hoaaah\LaravelMenu;

use Illuminate\Support\Facades\Request;

class Breadcrumb {
    public $divClass = 'sidebar-nav navbar-collapse';
    public $secondLevelClass = "nav-second-level";
    public $thirdLevelClass = "nav-third-level";
    public $activeClass = "active";
    public $linkTemplate = '<a href="{url}">{icon} {label}</a>';
    public $defaultIconHtml = '<i class="fa fa-circle-o"></i> ';    
    public $homeUrl = '';

    public static function render($params){
        $render = '<div class="'.$this->divClass.'">
                        <ul class="nav in">';
        foreach($params['items'] as $items){

        }
        $render .= '</ul></div>';
        echo $render;
    }

    public function renderItem($item){
        if(!$this->icon) $this->icon = $defaultIconHtml;
        $render = '<li>';
        $render .= '<a href="'.$item->url.'" '.$isActive.' > <i class="'.$this->icon.'" <a/>'
        if($item->items){
            
        }
        $render .= '</li>';
    }

    public function begin(){
        $urlUnique = NULL;
        foreach(Request::segments() as $segments){
            $urlUnique .= '/'.$segments;
        }
        if($urlUnique != '/') {
            echo '
            <ul class="breadcrumb">
                <i class="fa fa-home"></i>
                <li><a href="/'.$this->homeUrl.'">Home</a></li>';
        }ELSE{
            echo '';
        }
    }

    public function add($params){
        if(!array_key_exists('url', $params)){
            $params['url'] = '';
            $tag = 'span';
        }else{
            $params['url'] = 'href="'.url($params['url']).'"';
            $tag = 'a';
        }
        if(!array_key_exists('label', $params)) $params['label'] = 'Use label params!';
        echo '<li><'.$tag.' '.$params['url'].' >'.$params['label'].'</'.$tag.'></li>';
    }

    public function end(){
        echo '</ul>';
    }
}
