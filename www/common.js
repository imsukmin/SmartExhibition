//		admin_board.php에 date부분에 작성일을 넣을 용도로 사용될 함수
function inputDate() {
	var date = document.getElementByName('date');
	var d = new date();
	var today = d.getYear() + "." + d.getMonth() + "." + d.getDate();

	date.value = today;
	document.form.date2.value = today;
}
