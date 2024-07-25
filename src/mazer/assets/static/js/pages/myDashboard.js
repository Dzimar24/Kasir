const flashData = $(".flash-data").data("flashdata");

if (flashData) {
	Swal.fire({
		icon: "success",
		title: "Success Login",
		text: flashData,
	});
}

//? Buttons Deleted
$(".log-out").on("click", function (e) {
	e.preventDefault();
	const href = $(this).attr("href");

	Swal.fire({
		title: "Are you sure ?",
		text: "Are you sure you want to log out?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, Log out!",
	}).then((result) => {
		if (result.isConfirmed) {
			document.location.href = href;
		}
	});
});
