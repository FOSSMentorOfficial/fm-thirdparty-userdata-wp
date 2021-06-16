/*global jQuery */
/**
* SVG replacer. Replaces <img src=svg/> into SVG element.
*
* Credits: How to change color of SVG image using CSS (jQuery SVG image replacement)?, http://stackoverflow.com/q/11978995
*/
jQuery(function(){
	"use strict";
	try {
		//alert("asdasd");

		function createTable(tableData) {
			var html = '<tr><td>ID</td><td>'+tableData['id']+'</td></tr>';
			html += '<tr><td>Name</td><td>'+tableData['name']+'</td></tr>';
			html += '<tr><td>Username</td><td>'+tableData['username']+'</td></tr>';
			html += '<tr><td>Email</td><td>'+tableData['email']+'</td></tr>';
			html += '<tr><td>Street</td><td>'+tableData['address']['street']+'</td></tr>';
			html += '<tr><td>Suite</td><td>'+tableData['address']['suite']+'</td></tr>';
			html += '<tr><td>City</td><td>'+tableData['address']['city']+'</td></tr>';
			html += '<tr><td>Zipcode</td><td>'+tableData['address']['zipcode']+'</td></tr>';
			html += '<tr><td>Latitude</td><td>'+tableData['address']['geo']['lat']+'</td></tr>';
			html += '<tr><td>Longitude</td><td>'+tableData['address']['geo']['lng']+'</td></tr>';
			html += '<tr><td>Phone</td><td>'+tableData['phone']+'</td></tr>';
			html += '<tr><td>Website</td><td>'+tableData['website']+'</td></tr>';
			html += '<tr><td>Company Name</td><td>'+tableData['company']['name']+'</td></tr>';
			html += '<tr><td>Catch Phrase</td><td>'+tableData['company']['catchPhrase']+'</td></tr>';
			html += '<tr><td>Company BS</td><td>'+tableData['company']['bs']+'</td></tr>';
			jQuery("#user-detail-table").show();
			 	jQuery("#user-detail-table").html("");
			 	jQuery("#user-detail-table").html(html);
			 	//document.getElementById('user-detail-table').innerHTML = html;
		}

		jQuery(document).on('click','.user-link',function(){
			var id = $(this).attr('user-id');
			//console.log(this);
			//console.log(id);
			jQuery.ajax({
			  type:"GET",
			  dataType: 'html',
			  url: 'https://jsonplaceholder.typicode.com/users/'+id,
			  success: function(res){
			      var user =  JSON.parse(res);
			      createTable(user);
			  }
			});
			
			//jQuery("#user-detail-table").show();
			/*var x = document.getElementById("user-detail-table");
			console.log(x);
			if (x.style.display == "none") {
			    x.style.display = "block";
			}*/
		});		

	}catch(x) {}
});


// Text Rotator Widget
var textRotator = function(element) {
	"use strict";
	var words = jQuery(element),
		total = words.length - 1,
		position = 0,
		current = null,
		timer = null;
	jQuery(element).first().addClass('active');
	var autoSlide = function() {
		words.removeClass('active');
		if (position === total) {
			position = 0;
		} else {
			position = position + 1;
		}
		//console.log(position);
		words.eq(position).addClass('active');
	};
	timer = setInterval(autoSlide, 3000);
};
jQuery(document).ready(function() {
	//alert("asdasd");
	"use strict";
	//textRotator('.ozy-rotating_text_widget .change-text span');
});