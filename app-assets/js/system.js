// Base Profile Photo
const baseProfilePhoto = `${appUrl}assets/metronic/media/avatars/blank.png`;

// Remove datatables error warning
$.fn.dataTable.ext.errMode = "none";

/** ALPINE JS */
document.addEventListener("alpine:init", () => {
	Alpine.store("global", {
		pageTitle: "",
		userData: {},

		changeState(data) {
			this[data.object ?? ""] = data.value ?? "";
		},
	});
});
/** END ALPINE JS */

/*
	- Function : main menu
	- Desc : digunakan untuk mengatur main menu
	- Created at : 21 Februari 2023 09:58
	- Created by : bagusdwinurul@gmail.com
*/
$(document).on("click", ".menu-item .menu-link", function () {
	if ($("#kt_body").attr("data-kt-aside-minimize") != null) {
		if (
			$("#kt_body").attr("data-kt-aside-minimize") == "on" &&
			$(this).attr("href") == null
		) {
			$("#kt_body").attr("data-kt-aside-minimize", "");
			$("#kt_aside_toggle").removeClass("active");
		}
	}
});

// Add Modal Stackable Function
$(document).on("show.bs.modal", ".modal", function () {
	// let zIndex = 1040 + 10 * $(".modal:visible").length;
	let currentModalIndex = $(this).css("z-index");
	let index_highest = 0;

	$(".modal:visible").each(function () {
		const index_current = parseInt($(this).css("zIndex"));
		if (index_current >= index_highest) {
			index_highest = index_current;
		}
	});

	if (currentModalIndex <= index_highest) {
		currentModalIndex = index_highest + 10;
	}

	// console.log(currentModalIndex);

	$(this).css("z-index", currentModalIndex);
	setTimeout(() =>
		$(".modal-backdrop")
			.not(".modal-stack")
			.css("z-index", currentModalIndex - 1)
			.addClass("modal-stack")
	);
});

// Handle Modal Close Stackable
$(document).on("hidden.bs.modal", ".modal", function () {
	if ($(".modal.show").length) $("body").addClass("modal-open");
});

// Datatables plugins
$.fn.dataTable.Api.register("order.neutral()", function () {
	return this.iterator("table", function (s) {
		s.aaSorting.length = 0;
		s.aiDisplay.sort(function (a, b) {
			return a - b;
		});
		s.aiDisplayMaster.sort(function (a, b) {
			return a - b;
		});
	});
});

// Handle Ajax request expired session
$(document).ajaxError(function (event, xhr, options, exc) {
	if (xhr.status == 403 && xhr.responseJSON.message == "Session expired") {
		showSwal(
			"Session Habis",
			"Session telah habis silahkan login ulang",
			"error"
		);
		setTimeout(function () {
			window.location.href = xhr.responseJSON.redirecTo;
		}, 3000);
	}
});

/* === Global Function === */
function showSwal(title, msg, icon) {
	Swal.fire(title, msg, icon);
}

function showBasicToastr(event, msg, time = 1000) {
	toastr.options = {
		closeButton: false,
		debug: false,
		newestOnTop: true,
		progressBar: true,
		positionClass: "toast-top-right",
		preventDuplicates: false,
		onclick: null,
		showDuration: time,
		hideDuration: time,
		timeOut: time,
		extendedTimeOut: time,
		showEasing: "swing",
		hideEasing: "linear",
		showMethod: "fadeIn",
		hideMethod: "fadeOut",
	};

	switch (event) {
		case "success":
			toastr.success(msg);
			break;
		case "warning":
			toastr.warning(msg);
			break;
		case "error":
			toastr.error(msg);
			break;
		default:
			toastr.info(msg);
			break;
	}
}

function openModal(element) {
	$(element).modal({ backdrop: "static", keyboard: false });
	$(element).modal("show");
}

function closeModal(element) {
	$(element).modal({ backdrop: "static", keyboard: false });
	$(element).modal("hide");
}

function startBlockPage(message = "") {
	if (nullSafety(message)) {
		$.blockUI({
			message: message,
			baseZ: 99999,
		});
	} else {
		$.blockUI({
			baseZ: 99999,
		});
	}
}

function endBlockPage() {
	$.unblockUI();
}

function jsonParse(response) {
	try {
		return JSON.parse(response);
	} catch (e) {
		// showSwal("Error", "Response sistem tidak valid", "error");
		// return null;
		return response;
	}
}

function nullSafety(data, prop = null) {
	try {
		if (prop != null) {
			if (_.isNil(data[prop])) {
				return false;
			}

			if (_.isEmpty(data[prop])) {
				return false;
			}

			if (data[prop].length <= 0) {
				return false;
			}
		} else {
			if (_.isNil(data)) {
				return false;
			}

			if (_.isEmpty(data.toString())) {
				return false;
			}

			if (data.length <= 0) {
				return false;
			}
		}

		return true;
	} catch (error) {
		return false;
	}
}

function formatRupiah(angka, prefix) {
	var number_string = angka.replace(/[^,\d]/g, "").toString(),
		split = number_string.split(","),
		sisa = split[0].length % 3,
		rupiah = split[0].substr(0, sisa),
		ribuan = split[0].substr(sisa).match(/\d{3}/gi);
	if (ribuan) {
		separator = sisa ? "." : "";
		rupiah += separator + ribuan.join(".");
	}
	rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
	return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}

function numberFormat(val = 0, withRupiah = false) {
	const currency = withRupiah == true ? "Rp. " : "";
	return `${currency}${Intl.NumberFormat("id-ID").format(val)}`;
}

function separatorFormat(val = 0, event = null, currency = "IDR") {
	//other than numbers and "," cannot be input if event is activated
	if (nullSafety(event)) {
		if (event.which >= 37 && event.which <= 40) return;
	}

	if (currency == "IDR") {
		if ((val.match(/,/g) || []).length > 1) {
			return val.slice(0, -1);
		}

		return (
			val
				// Keep only digits and decimal points:
				.replace(/[^\d,]/g, "")
				// Remove duplicated decimal point, if one exists:
				.replace(/^(\d*\,)(,*)\,(,*)$/, "$1$2$3")
				// Keep only two digits past the decimal point:
				.replace(/\,(\d{2})\d+/, ",$1")
				// Add thousands separators:
				.replace(/\B(?=(\d{3})+(?!\d))/g, ".")
		);
	} else {
		return (
			val
				// Keep only digits and decimal points:
				.replace(/[^\d.]/g, "")
				// Remove duplicated decimal point, if one exists:
				.replace(/^(\d*\.)(.*)\.(.*)$/, "$1$2$3")
				// Keep only two digits past the decimal point:
				.replace(/\.(\d{2})\d+/, ".$1")
				// Add thousands separators:
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
		);
	}
}

function formatUmur(date, format = "DD/MM/YYYY", getObject = false) {
	let now = moment();
	let data = moment(date, format);

	let years = now.diff(data, "year");
	data.add(years, "years");

	let months = now.diff(data, "months");
	data.add(months, "months");

	var days = now.diff(data, "days");

	switch (getObject) {
		case "year":
			return years;
			break;

		default:
			break;
	}

	return `${years} Tahun ${months} Bulan ${days} Hari`;
}

function getDateNow(type = false) {
	switch (type) {
		case "standard":
			return moment().format("DD-MM-YYYY");
		case "standardTime":
			return moment().format("DD-MM-YYYY HH:MM:SS");
		case "reverseStandard":
			return moment().format("YYYY-MM-DD");
		default:
			return moment().format("YYYY-MM-DD HH:MM:SS");
	}
}

function getRndInteger(min = 1, max = 100000) {
	return Math.floor(Math.random() * (max - min + 1)) + min;
}

function is_user_has_valid_role_name_access(rolename) {
	if (Array.isArray(rolename)) {
		return rolename.includes(Alpine.store("global").userData.ROLE_NAME);
	} else {
		if (Alpine.store("global").userData.ROLE_NAME == rolename) {
			return true;
		}
	}

	return false;
}

function setInputFilter(textbox, inputFilter, errMsg) {
	$(textbox).on(
		"input keydown keyup mousedown mouseup select contextmenu drop focusout",
		function (e) {
			if (inputFilter(this.value)) {
				// Accepted value
				if (["keydown", "mousedown", "focusout"].indexOf(e.type) >= 0) {
					$(this).removeClass("input-error");
					this.setCustomValidity("");
				}
				this.oldValue = this.value;
				this.oldSelectionStart = this.selectionStart;
				this.oldSelectionEnd = this.selectionEnd;
			} else if (this.hasOwnProperty("oldValue")) {
				// Rejected value - restore the previous one
				$(this).addClass("input-error");
				this.setCustomValidity(errMsg);
				this.reportValidity();
				this.value = this.oldValue;
				this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
			} else {
				// Rejected value - nothing to restore
				this.value = "";
			}
		}
	);
}

var resetActiveItem = function () {
	var list;
	var parents;
	var subParents1;

	list = document.querySelectorAll(".menu-link.active");

	for (var i = 0, len = list.length; i < len; i++) {
		var el = list[i];
		KTUtil.removeClass(el, "active");
		KTUtil.removeClass(el, "here");
		KTUtil.removeClass(el, "show");
		KTUtil.removeClass(el, "hover");
	}

	parents = document.querySelectorAll(".menu-item.menu-accordion");

	for (var i = 0, len = parents.length; i < len; i++) {
		var el = parents[i];
		KTUtil.removeClass(el, "active");
		KTUtil.removeClass(el, "here");
		KTUtil.removeClass(el, "show");
		KTUtil.removeClass(el, "hover");
	}

	subParents1 = document.querySelectorAll(".menu-sub.menu-sub-accordion");

	for (var i = 0, len = subParents1.length; i < len; i++) {
		var el = subParents1[i];
		KTUtil.removeClass(el, "active");
		KTUtil.removeClass(el, "here");
		KTUtil.removeClass(el, "show");
		KTUtil.removeClass(el, "hover");
	}
};

var setActiveItem = function (item = null) {
	// reset current active item
	resetActiveItem();
	KTUtil.addClass(item, "active");

	var parents = KTUtil.parents(item, ".menu-item.menu-accordion");

	parents.forEach(function (el, i) {
		KTUtil.addClass(parents[i], "show");
		KTUtil.addClass(parents[i], "here");
	});

	Alpine.store("global").changeState({
		object: "pageTitle",
		value: $(item).find(".menu-title").text(),
	});
};

var waitForEl = function (selector, callback) {
	if (jQuery(selector).length) {
		callback();
	} else {
		setTimeout(function () {
			waitForEl(selector, callback);
		}, 100);
	}
};