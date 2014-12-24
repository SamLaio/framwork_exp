<?php
class View {
	function __construct($page, $InData) {
		include_once 'hend.html';
		include_once "view/$page.html";
		include_once 'foot.html';
	}
}