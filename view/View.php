<?php
class View {
	function __construct($page, $InData) {
		include_once 'hend.html';
		include_once "$page.html";
		include_once 'foot.html';
	}
}