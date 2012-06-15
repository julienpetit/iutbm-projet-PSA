<?php

class CSV{

    static function export($datas,$filename){
        //header('Content-Type: text/csv;');
        //header('Content-Disposition: attachment; filename="'.$filename.'.csv"');
	$date=date("m-d-Y-h-m");
	$fp = fopen("./Data_Exort/$filename$date.csv","w");
        $i = 0;
        foreach($datas as $v){
            if($i==0){
                //echo '"'.implode('";"',array_keys($v)).'"'."\n";
	        fputs ($fp, '"'.implode('";"',array_keys($v)).'"'."\n");
            }
	    fputs ($fp, '"'.implode('";"',$v).'"'."\n");
            //echo '"'.implode('";"',$v).'"'."\n";
            $i++;
        }
	fclose($fp);
    }
        //
}

?>
