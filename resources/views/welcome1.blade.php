
<?php

if(isset($showTables) && !empty($showTables)){
 
    // echo 'showTables';
    $myecho = $showTables;
    `echo " showTables blade    " >>/tmp/qaz`;
    `echo "$myecho" >>/tmp/qaz`;
    echo $showTables;
    exit;
}else{

  
    ob_start();

    $myecho = "entrancing on else";
    `echo " showTables on else    " >>/tmp/qaz`;
    `echo "$myecho" >>/tmp/qaz`;
  

echo<<<END
                      <div class="btn-group" role="group" aria-label="...">
                        <a href="/insert_tables" type="button" class="btn btn-default">Добавить запись</a>
                        <a href="/show_category" type="button" class="btn btn-default">Редактировать категории</a>
                        <a href="/show_subcat" type="button" class="btn btn-default">Редактировать субкатегории</a>
                        <a href="/show_descr" type="button" class="btn btn-default">Редактировать описание</a>
                        <a href="/show_size" type="button" class="btn btn-default">Редактировать размер</a>
                        <a href="/show_color" type="button" class="btn btn-default">Редактировать цвет</a>
                        <a href="/show_pict" type="button" class="btn btn-default">Редактировать картинки</a>
                      </div>
                  </div>
              </div>
              <br><br>
END;

  

  
    $showTables = ob_get_contents();

    $myecho = $showTables;
    `echo " showTables ob_get    " >>/tmp/qaz`;
    `echo "$myecho" >>/tmp/qaz`;

    ob_end_clean();

    // Cache::forever('showTables', $showTables);
    // Сохранение кэш-файла с контентом
    $fp = fopen('./cache/showTables.cache', 'w');
    fwrite($fp, $showTables);
    fclose($fp);

    $fp = fopen('./cache/showTables.cache', 'r');
    $showTables = readfile('./cache/showTables.cache');
    fclose($fp);
    
    $myecho = $showTables;
    `echo " showTables ob_get read    " >>/tmp/qaz`;
    `echo "$myecho" >>/tmp/qaz`;
    
    // echo $showTables;
  


}


   
