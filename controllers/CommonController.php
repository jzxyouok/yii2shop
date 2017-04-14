<?php

namespace  app\controllers;
use yii\web\Controller;
use app\models\Category;
use app\models\Product;
use app\models\User;
use app\models\Cart;

use Yii;
class CommonController extends Controller
{
  public function init()   // 调用控制器下方法,先自动调用init方法
  {
    $menu = Category::getMenu();
    $this->view->params['menu'] = $menu;
    $data = [];
    $data['products']=[];
    $total = 0;
    if(Yii::$app->session['isLogin']){   // 在模板中显示用户购物车中商品
      $usermodel = User::find()->where('username = :name',[":name"=>Yii::$app->session['loginname']])->one();
      if(!empty($usermodel) && !empty($usermodel->userid)) {   // user表里面这两个非空
        $userid = $usermodel->userid;
        $carts = Cart::find()->where('userid = :uid',[':uid'=>$userid])->asArray()->all();
        foreach($carts as $k=>$pro){
          $product = Product::find()->where('productid=:pid',[':pid'=>$pro['productid']])->one();
          $data['products'][$k]['cover'] = $product->cover;
          $data['products'][$k]['title'] = $product->title;
          $data['products'][$k]['productnum'] = $pro['productnum'];
          $data['products'][$k]['price'] = $pro['price'];
          $data['products'][$k]['productid'] = $pro['productid'];
          $data['products'][$k]['cartid'] = $pro['cartid'];
          $total += $data['products'][$k]['price']*$data['products'][$k]['productnum'];

        }
      }
    }
    $data['total'] = $total;
    $this->view->params['cart']=$data;

    // 模板中查询四种分类商品
    $tui = Product::find()->where('istui="1" and ison="1"')->orderby('createtime desc')->limit(3)->all();
    $new = Product::find()->where('ison = "1"')->orderby('createtime desc')->limit(3)->all();
    $hot = Product::find()->where('ison = "1" and ishot = "1"')->orderby('createtime desc')->limit(3)->all();
    $sale = Product::find()->where('ison = "1" and issale = "1"')->orderby('createtime desc')->limit(3)->all();
    $this->view->params['tui'] = (array)$tui;
    $this->view->params['new'] = (array)$new;
    $this->view->params['hot'] = (array)$hot;
    $this->view->params['sale'] = (array)$sale;

    // 查询父级所有分类
    $category = Category::find()->where('parentid = "0"')->orderby('createtime desc')->all();
    $this->view->params['category'] = (array)$category;
  }
}