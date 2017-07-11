<?php
namespace hoaaah\LaravelMenu;

use Illuminate\Support\Facades\Request;

class Menu {
    public $divClass = 'sidebar-nav navbar-collapse';
    public $ulClass = 'nav';
    public $ulId = 'side-menu';
    public $secondLevelClass = "nav-second-level";
    public $thirdLevelClass = "nav-third-level";
    public $activeClass = "active";
    public $linkTemplate = '<a href="{url}">{icon} {label}</a>';
    public $defaultIconHtml = 'fa fa-circle-o';
    public $homeUrl = '';
    public $icon;

    public function render($params){
        if(isset($params['options'])){
            $options = $params['options'];
            if(isset($options['divClass'])) $this->divClass = $options['divClass'];
            if(isset($options['ulClass'])) $this->ulClass = $options['ulClass'];
            if(isset($options['ulId'])) $this->ulId = $options['ulId'];
        }
        $render = '<div class="'.$this->divClass.'"><ul class="'.$this->ulClass.'" id="'.$this->ulId.'">';
        foreach($params['items'] as $items){
            // echo $items['label'];
            if($this->isVisible($items)) $render .= $this->renderItems($items);
        }
        $render .= '</ul></div>';
        echo $render;
    }

    public function renderItems($item){
        if(!isset($item['icon'])){
            $this->icon = $this->defaultIconHtml;
        }else{
            $this->icon = $item['icon'];
        }
        // $isActive = $this->isItemActive($item['url']);
        $render = '<li>';
        if(isset($item['items'])){
            $render .= '<a href="#"><i class="'.$this->icon.'"></i> '.$item['label'].'<i class="fa fa-angle-right pull-right"></i></a>';
            $render.= '<ul class="nav nav-second-level collapse">';
            foreach($item['items'] as $item)
            {
                // if(!isset($item['visible']) || $item['visible'] == true){
                if($this->isVisible($item)){
                    if(isset($item['items'])){
                        $render .= '<li><a href="#"><i class="'.$this->icon.'"></i> '.$item['label'].'<i class="fa fa-angle-right pull-right"></i></a>';
                        $render.= '<ul class="nav nav-third-level">';
                        foreach($item['items'] as $item2){
                             if($this->isVisible($item2)){
                                $render .= '<li>';
                                $render .= $this->renderItem($item2);
                                $render .= '</li>';
                             }
                        }
                        $render .='</ul></li>';
                    }else{
                        if($this->isVisible($item)){
                            $render .= '<li>';
                            $render .= $this->renderItem($item);
                            $render .= '</li>';
                        }
                    }

                }
            }
            $render .='</ul>';
        }else{
            $render .= $this->renderItem($item);
        }
        $render .= '</li>';

        return $render;
    }

    public function renderItem($item){
        if(!isset($item['icon'])){
            $this->icon = $this->defaultIconHtml;
        }else{
            $this->icon = $item['icon'];
        }
        $isActive = $this->isItemActive($item['url']);
        return '<a href="'.url($item['url']).'" '.$isActive.' > <i class="'.$this->icon.'"></i> '.$item['label'].'</a>';
    }

    protected function isItemActive($item)
    {
        // if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
        //     $route = $item['url'][0];
        //     if ($route[0] !== '/' && Yii::$app->controller) {
        //         $route = ltrim(Yii::$app->controller->module->getUniqueId() . '/' . $route, '/');
        //     }
        //     $route = ltrim($route,'/');
        //     if ($route != $this->route && $route !== $this->noDefaultRoute && $route !== $this->noDefaultAction) {
        //         return false;
        //     }
        //     unset($item['url']['#']);
        //     if (count($item['url']) > 1) {
        //         foreach (array_splice($item['url'], 1) as $name => $value) {
        //             if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
        //                 return false;
        //             }
        //         }
        //     }
        //     return true;
        // }
        // return false;
        // return 'class="active"';
        return '';
    }

    protected function isVisible($item){
        if(isset($item['visible']) && $item['visible'] == false ){
            return false;
        }else{
            return true;
        }
    }
}
