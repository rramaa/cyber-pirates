/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var html = $("html").html();
$(function() {
			$("<pre />", {
				"html":   '&lt;!DOCTYPE html>\n&lt;html>\n' + 
						$("html")
							.html()
							.replace(/[<>]/g, function(m) { return {'<':'&lt;','>':'&gt;'}[m]})
							.replace(/((ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?)/gi,'<a href="$1">$1</a>') + 
						'\n&lt;/html>',
				"class": "prettyprint"
			}).appendTo("#source-code");
			
			prettyPrint();
		});

$('document').ready(function(){
    $("#answer-box").focus();
})