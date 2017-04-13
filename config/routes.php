<?php

return array(

  'user/comments'         => 'user/comments',     // actionComment в UserController
  'user/register'         => 'user/register',     // actionRegister в UserController
  'user/login'            => 'user/login',        // actionLogin в UserController
  'user/logout'           => 'user/logout',       // actionLogout в UserController
  
  'blog/category/([0-9]+)'=>  'category/index/$1',// actionIndex в CategoryController
  'blog/article/([0-9]+)' =>  'blog/article/$1',  // actionArticle в BlogController
  'blog'                  =>  'blog/index',       // actionIndex в BlogController

  'cabinet/edit'          => 'cabinet/edit',      // actionEdit в CabinetController
  'cabinet'               => 'cabinet/index',     // actionIndex в CabinetController

  'about'                 =>  'site/about',       // actionAbout в SiteController
  'contact'               =>  'site/contact',     // actionContact в SiteController
  ''                      =>  'site/index',       // actionIndex в SiteController
);