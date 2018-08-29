if (navigator.userAgent.match(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i)) {
    $("html").addClass("ismobile");
}
$(function() {
    $("html").hasClass("ismobile") || $(".page-loader")[0] && setTimeout(function() {
        $(".page-loader").fadeOut()
    }, 500)
});
$(function() {
    $(".main-profile-menu").hide();
    $(".submenu-toggle").next().hide();
    $(".profile-info").on("click", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(".main-profile-menu").slideToggle(200);
    });
    $(".submenu-toggle").on("click", function(e) {
        e.stopPropagation();
        e.preventDefault();
	$(this).next().slideToggle(200);
    });
	/*
    function e(e, t, n) {
        $(e).mCustomScrollbar({
            theme: t,
            scrollInertia: 100,
            axis: "yx",
            mouseWheel: {
                enable: !0,
                axis: n,
                preventDefault: !0
            }
        })
    }
    */
});

    function sideToggle() {
        $(".sidebar").toggleClass("toggled");
        event.stopPropagation();
        event.preventDefault();
    }
    function userMenu() {
        $(".user-menu").addClass("visible");
        event.stopPropagation();
        event.preventDefault();
    }
    function searchMenu() {
        $(".search-menu").addClass("visible");
        event.stopPropagation();
        event.preventDefault();
    }
    $(function() {
        $(document).on("click", function() {
                if($(event.target).closest(".user-menu").length == 0) {
                        $(".user-menu").removeClass("visible");
                }
                if($(event.target).closest(".search-menu").length == 0) {
                        $(".search-menu").removeClass("visible");
                }
                if($(event.target).closest(".sidebar").length == 0) {
                    if ($(".sidebar.toggled").length > 0) {
                        $(".sidebar.toggled").removeClass("toggled");
                    }
                }
        });
    });
