<?php
function GetPageBar($InData){
	$list = $InData['count'];/*資料總數*/
	$list_nub = $InData['row'];/*每頁顯示的資料筆數*/
	$pages = ceil($list/$list_nub);/*總頁數*/
	$page = $InData['page'];/*目前所在的頁數*/

	/*顯示在下方的主要陣列，0為pagebar前的 "<< <"，1為pagebar主體，2為"> >>"*/
	$PageBar=array(0=>'',1=>'',2=>'');
	/*每一個按鈕的css，1為放置的按鈕位置，0,2為css*/
	$defStyle = array(
		0=>"<span style='padding-left:10px;padding-right:10px;visibility:visible;'>",
		1=>'',
		2=>'</span>'
	);

	$range=5;/*pagebar要顯示的總數*/
	$st = 1;/*設定開始的數字*/
	$ed = $range;/*設定結束的數字*/
	/*
	如果所在的頁數大於或等於要顯示的頁數
	就把開始的數字設定為總數的一半
	就把結束的數字設定為總數的另一半
	*/
	if($page >= $range){
		$st = ($page - floor($range/2));
		$ed = ($page + floor($range/2));
	}

	/*如果結束的數字大於顯示總數，就修正開始為顯示總數減一，結束為總頁數*/
	if($ed > $pages){
		$st = ($pages - ($range - 1));
		$ed = $pages;
	}

	/*把設定為的pagebar丟進陣列*/
	for($i = $st; $i <= $ed; $i++){
		if($i >0){
			$PageBar[1][] = $i;
		}
	}

	/*如果開始頁不在pagebar陣列中，就PageBar[0]設定為 "<< <"*/
	if(!in_array(1,array_values($PageBar[1]))){
		$defStyle[1] = "<a href = '?page=1'> << </a>";
		$PageBar[0] = implode('',$defStyle);

		$defStyle[1] = "<a href = '?page=".($page-1)."'> < </a>";
		$PageBar[0] .= implode('',$defStyle);
	}
	/*如果總數頁不在pagebar陣列中，就PageBar[2]設定為 "> >>"*/
	if(!in_array($pages,array_values($PageBar[1]))){
		$defStyle[1] = "<a href = '?page=".($page+1)."'> > </a>";
		$PageBar[2] = implode('',$defStyle);

		$defStyle[1] = "<a href = '?page=$pages'> >> </a>";
		$PageBar[2] .= implode('',$defStyle);
	}

	/*開始把pagebar[1]實體化，並且判斷目前頁數在哪*/
	foreach($PageBar[1] as $key => $val){
		$defStyle[1]= "<a href = '?page=$val'>$val</a>";
		if($val == $page){
			$defStyle[1]= "<span class=\"redText\"><b>[$page]</b></span>";
		}
		$PageBar[1][$key] = implode('',$defStyle);
	}
	$PageBar[1] = implode('',$PageBar[1]);

	/*把弄好的pagebar陣列印出來*/
	return "<div id = 'page_bar'>" . implode('',$PageBar). "</div>";
}