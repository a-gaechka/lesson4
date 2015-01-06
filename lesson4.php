
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
    global $param;
    global $name;
    global $kol_order;
    $kol_order=0;
    global $kol_order_all;
    $kol_order_all=0;
    global $price_all;
    $price_all=0;
    global $bd;
    global $coupon;
    $coupon=0;
    static $diskont;
    static $diskont1;
    static $diskont2;


    if($bd['игрушка детская велосипед']['количество заказано']>=3){
        $coupon= round(($bd['игрушка детская велосипед']['цена']/100)*30);
    }
    foreach($basket as $name => $param){
        
        
        if ($param['количество заказано']>0){
          $kol_order ++;
        }
        $kol_order_all+=$param['количество заказано'];
        switch ($param['diskont']){
            case 'diskont1':
            {
                $param['diskont']=1;
                $diskont1=round($param['цена']/10);
                break;
            }
            case 'diskont2':
            {
                $param['diskont']=2;
                $diskont2=round($param['цена']/100*20);
                break;
            }
            default:
            {
                $param['diskont']=0;
                break;
            }
        }
        echo '<span style="margin:0 10px 0 0; color:#555; float:left;">Название товара:</span>'.' '.$name;
        echo "<br>";
        echo '<span style="margin:0 10px 0 0; color:#555; float:left;">Цена товара:</span>'.$param['цена'].' '.'руб'."<br>";
        echo '<span style="margin:0 10px 0 0; color:#555; float:left;">Количество заказано:</span>'.$param['количество заказано'].' '.'шт'."<br>";
        echo '<span style="margin:0 10px 0 0; color:#555; float:left;">Осталось на складе:</span>'.$param['осталось на складе'].' '.'шт'."<br>";
        echo '<span style="margin:0 10px 0 0; color:#555; float:left;">Скидка:</span>'.$param['diskont'].'%'."<br>";
        echo '<hr>';
        echo "<br>";
        $price_all+=$param['цена']*$param['количество заказано'];
    }
        $price_all=($price_all-$coupon)-$diskont1-$diskont2;
}
parse_basket($bd);

echo "Наименовний было заказано:".' '.$kol_order."<br>";
echo "Общее количество товара:".' '.$kol_order_all."<br>";
echo "Какова общая сумма заказа(с учетом скидки):".' '.$price_all."<br>";
echo "Скидка на товар \"игрушка детская велосипед\":".' '.$coupon."<br>";
echo "<br>";

function notification($string, $sign="С уважением, магазин \"Подарки\""){
    echo $string ." ".$sign;
}
function show_text(){
    echo "Отправить сообщение на почту покупателя<br>";  
}
$func = "show_text";
$func();
$func = "notification";
$func("Здравствуйте, username!<br> Данного товара на складе нету.<br>");

echo "<br>";
echo "<br>";
$coupon= "show_text";
$coupon();
$coupon= "notification";
$coupon("Здравствуйте, username!<br> Вам была сделанны скидка 30% на товар \"игрушка детская велосипед\"<br>");

