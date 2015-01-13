
<?php
$ini_string='
[игрушка мягкая мишка белый]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[одежда детская куртка синяя синтепон]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[игрушка детская велосипед]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';

';
$bd=  parse_ini_string($ini_string, true);

echo '<h3 style="color:#ff3600">Полный список</h3>';
function parse_basket($basket){
    global $kol_order;
    $kol_order=0;
    global $kol_order_all;
    $kol_order_all=0;
    global $price_all;
    $price_all=0;
    global $bd;
    global $coupon;
    $coupon=0;
   
    
    foreach($basket as $name => $param){
        if ($param['количество заказано']>0){
          $kol_order ++;
        }
        $kol_order_all+=$param['количество заказано'];
        
        $notification_order=notification_order($param['количество заказано'],$param['осталось на складе']);
        echo "<br>";
        echo "<br>";
        $diskont=$param['diskont'];
        if($param['количество заказано']>$param['осталось на складе']){
            if ($name == 'игрушка детская велосипед' && $bd['игрушка детская велосипед']['количество заказано']>=3) {
                $diskont=30;
                $diskont_all= round((($param['цена']*$param['осталось на складе'])/100*30), 2); 
                $cupon=cupon($bd['игрушка детская велосипед']['количество заказано'], $bd['игрушка детская велосипед']['цена']);
                echo $cupon."<br>";
                echo '<br>';
             }elseif (substr($diskont,7,1)==1){
                 $diskont=10;
                 $diskont_all= round((($param['цена']*$param['осталось на складе'])/100*10),2);
             }elseif (substr($diskont,7,1)==2){
                 $diskont=20;
                 $diskont_all= round((($param['цена']*$param['осталось на складе'])/100*20),2);
             }elseif (substr($diskont,7,1)==0) {
                 $diskont=0;
                 $diskont_all=0;
             }

             $price_products=($param['цена']*$param['осталось на складе'])-$diskont_all;
             $price_all+=$price_products;
        }  else {
             if ($name == 'игрушка детская велосипед' && $bd['игрушка детская велосипед']['количество заказано']>=3) {
                $diskont=30;
                $diskont_all= round((($param['цена']*$param['количество заказано'])/100*30), 2); 
                $cupon=cupon($bd['игрушка детская велосипед']['количество заказано'], $bd['игрушка детская велосипед']['цена']);
                echo $cupon."<br>";
                echo '<br>';
             }elseif (substr($diskont,7,1)==1){
                 $diskont=10;
                 $diskont_all= round((($param['цена']*$param['количество заказано'])/100*10),2);
             }elseif (substr($diskont,7,1)==2){
                 $diskont=20;
                 $diskont_all= round((($param['цена']*$param['количество заказано'])/100*20),2);
             }elseif (substr($diskont,7,1)==0) {
                 $diskont=0;
                 $diskont_all=0;
             }

             $price_products=($param['цена']*$param['количество заказано'])-$diskont_all;
             $price_all+=$price_products;
        }
        
        echo '<span style="margin:0 10px 0 0; color:#555; float:left;">Название товара:</span>'.' '.$name;
        echo "<br>";
        echo '<span style="margin:0 10px 0 0; color:#555; float:left;">Цена товара:</span>'.$param['цена'].' '.'руб'."<br>";
        echo '<span style="margin:0 10px 0 0; color:#555; float:left;">Количество заказано:</span>'.$param['количество заказано'].' '.'шт'."<br>";
        echo '<span style="margin:0 10px 0 0; color:#555; float:left;">Осталось на складе:</span>'.$param['осталось на складе'].' '.'шт'."<br>";
        echo '<span style="margin:0 10px 0 0; color:#555; float:left;">Скидка:</span>'.$diskont.'%'.' '.'='.' '.$diskont_all."<br>";
        echo '<span style="margin:0 10px 0 0; color:#555; float:left;">Стоимость товара:</span>'.' '.$price_products;
        echo $notification_order."<br>";
        echo '<hr>';
        echo "<br>"; 
    }
    
}
parse_basket($bd);
echo "Наименовний было заказано:".' '.$kol_order."<br>";
echo "Общее количество товара:".' '.$kol_order_all."<br>";
echo "Какова общая сумма заказа(с учетом скидки):".' '.$price_all."<br>";
echo "<br>";



function notification($string, $sign="С уважением, магазин \"Подарки\""){
    echo $string ." ".$sign;
}
function show_text(){
    echo '<span style="margin:0 10px 0 0; color:red; float:left;">Уведомление</span><br>';  
}
function notification_order($order, $balance_in_stock){
   if ($order>$balance_in_stock){
        $func = "show_text";
        $func();
        $func = "notification";
        $func("Здравствуйте, username!<br> Данного товара недостаточно на складе.<br>");
    }  else {
        $func = "show_text";
        $func();
        $func = "notification";
        $func("Здравствуйте, username!<br> Спасибо за покупку!<br>");
    } 
}

function cupon($kol, $price){
    if($kol>=3){
        $coupon= round(($price/100)*30);
        $coupon_show = "show_text";
        $coupon_show();
        $coupon_show= "notification";
        $coupon_show("Здравствуйте, username!<br> Вам была сделанны скидка 30% на товар \"игрушка детская велосипед\"<br>");
    }
}



    

    