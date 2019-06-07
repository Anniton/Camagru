document.addEventListener('scroll', function(event) {
	var element = event.target.scrollingElement;
    if (element.scrollHeight - element.scrollTop === element.clientHeight) {
		next_page = document.getElementById("pages").value;
		pictures = document.getElementById("pictures");
		next_page++;
		data = "pages="+next_page;
		req = new XMLHttpRequest();
		req.open("POST", "pages.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.onload = function () {
			if (req.readyState === req.DONE && req.status === 200) {
				res_data = req.response;
				pictures.insertAdjacentHTML('beforeend', res_data);
				document.getElementById("pages").value = next_page;
			}
		};
		req.send(data);
	}
});

function addLike(id) {
	req = new XMLHttpRequest();
	data = "pic_like_id=" + id;
	req.open("POST", "gallery.php", true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.onload = function () {
		if (req.readyState === req.DONE && req.status === 200) {
			res = req.response;
			resd = JSON.parse(res);
			document.getElementById("like_"+id).innerHTML = " " + resd.nb_like + " Likes";
		}
		else {
			console.log("Failure");
		}
	};
	req.send(data);
}

function comment_key(id) {
	if (event.key === "Enter")
		submit_comment(id);
}
function escapeHtml(unsafe){
    return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
		 .replace(/'/g, "&#039;");
 }
function submit_comment(id) {
	req = new XMLHttpRequest();
	comment = document.getElementById("comment_"+id).value;
	data = "comment=" + comment + "&pic_id=" + id;
	req.open("POST", "gallery.php", true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.onload = function () {
		if (req.readyState === req.DONE && req.status === 200) {
			res = req.response;
			resd = JSON.parse(res);
			comment = escapeHtml(comment);
			htmlinject = `<p class='comment'><b>` + resd['uname'] + `</b> ` + comment + `</p>`;
			comments = document.getElementById("comments_" + id);
			comments.insertAdjacentHTML('afterbegin', htmlinject);
		}
		else {
			console.log("Failure");
		}
	};
	req.send(data);
}