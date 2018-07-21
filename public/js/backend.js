if (navigator.userAgent.match(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i)) {
    $("html").addClass("ismobile");
}
$(function() {
    $("html").hasClass("ismobile") || $(".page-loader")[0] && setTimeout(function() {
        $(".page-loader").fadeOut()
    }, 500)
});
$(document).ready(function() {
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
    if (function() {
        var e = localStorage.getItem("ma-layout-status");
        $("#header-2")[0] || 1 == e && ($("body").addClass("sw-toggled"),
        $("#tw-switch").prop("checked", !0)),
        $("body").on("change", "#toggle-width input:checkbox", function() {
            $(this).is(":checked") ? setTimeout(function() {
                $("body").addClass("toggled sw-toggled"),
                localStorage.setItem("ma-layout-status", 1)
            }, 250) : setTimeout(function() {
                $("body").removeClass("toggled sw-toggled"),
                localStorage.setItem("ma-layout-status", 0)
            }, 250)
        })
    }(),
    $("html").hasClass("ismobile") || $(".c-overflow")[0],
    function() {
        $("body").on("click", "#top-search > a", function(e) {
            e.preventDefault(),
            $("#header").addClass("search-toggled"),
            $("#top-search-wrap input").focus()
        }),
        $("body").on("click", "#top-search-close", function(e) {
            e.preventDefault(),
            $("#header").removeClass("search-toggled")
        })
    }(),
    function() {
        $("body").on("click", "#menu-trigger, #chat-trigger", function(e) {
            e.preventDefault();
            var t = $(this).data("trigger");
            $(t).toggleClass("toggled"),
            $(this).toggleClass("open"),
            $(".sub-menu.toggled").not(".active").each(function() {
                $(this).removeClass("toggled"),
                $(this).find("ul").hide()
            }),
            $(".profile-menu .main-menu").hide(),
            "#sidebar" == t && ($elem = "#sidebar",
            $elem2 = "#menu-trigger",
            $("#chat-trigger").removeClass("open"),
            $("#chat").hasClass("toggled") ? $("#chat").removeClass("toggled") : $("#header").toggleClass("sidebar-toggled")),
            "#chat" == t && ($elem = "#chat",
            $elem2 = "#chat-trigger",
            $("#menu-trigger").removeClass("open"),
            $("#sidebar").hasClass("toggled") ? $("#sidebar").removeClass("toggled") : $("#header").toggleClass("sidebar-toggled")),
            $("#header").hasClass("sidebar-toggled") && $(document).on("click", function(e) {
                0 === $(e.target).closest($elem).length && 0 === $(e.target).closest($elem2).length && setTimeout(function() {
                    $($elem).removeClass("toggled"),
                    $("#header").removeClass("sidebar-toggled"),
                    $($elem2).removeClass("open")
                })
            })
        }),
        $("body").on("click", ".sub-menu > a", function(e) {
            e.preventDefault(),
            $(this).next().slideToggle(200),
            $(this).parent().toggleClass("toggled")
        })
    }(),
    $("body").on("click", '[data-clear="notification"]', function(e) {
        e.preventDefault();
        var t = $(this).closest(".listview")
          , n = t.find(".lv-item")
          , a = n.size();
        $(this).parent().fadeOut(),
        t.find(".list-group").prepend('<i class="grid-loading hide-it"></i>'),
        t.find(".grid-loading").fadeIn(1500);
        var i = 0;
        n.each(function() {
            var e = $(this);
            setTimeout(function() {
                e.addClass("animated fadeOutRightBig").delay(1e3).queue(function() {
                    e.remove()
                })
            }, i += 150)
        }),
        setTimeout(function() {
            $("#notifications").addClass("empty")
        }, 150 * a + 200)
    }),
    $(".dropdown")[0] && ($("body").on("click", ".dropdown.open .dropdown-menu", function(e) {
        e.stopPropagation()
    }),
    $(".dropdown").on("shown.bs.dropdown", function(e) {
        $(this).attr("data-animation") && ($animArray = [],
        $animation = $(this).data("animation"),
        $animArray = $animation.split(","),
        $animationIn = "animated " + $animArray[0],
        $animationOut = "animated " + $animArray[1],
        $animationDuration = "",
        $animArray[2] ? $animationDuration = $animArray[2] : $animationDuration = 500,
        $(this).find(".dropdown-menu").removeClass($animationOut),
        $(this).find(".dropdown-menu").addClass($animationIn))
    }),
    $(".dropdown").on("hide.bs.dropdown", function(e) {
        $(this).attr("data-animation") && (e.preventDefault(),
        $this = $(this),
        $dropdownMenu = $this.find(".dropdown-menu"),
        $dropdownMenu.addClass($animationOut),
        setTimeout(function() {
            $this.removeClass("open")
        }, $animationDuration))
    })),
    $("body").on("click", ".profile-menu > a", function(e) {
        e.preventDefault(),
        $(this).parent().toggleClass("toggled"),
        $(this).next().slideToggle(200)
    }),
    $(".fg-line")[0] && ($("body").on("focus", ".fg-line .form-control", function() {
        $(this).closest(".fg-line").addClass("fg-toggled")
    }),
    $("body").on("blur", ".form-control", function() {
        var e = $(this).closest(".form-group, .input-group")
          , t = e.find(".form-control").val();
        e.hasClass("fg-float") ? 0 == t.length && $(this).closest(".fg-line").removeClass("fg-toggled") : $(this).closest(".fg-line").removeClass("fg-toggled")
    })),
    $(".fg-float")[0] && $(".fg-float .form-control").each(function() {
        var e = $(this).val();
        0 == !e.length && $(this).closest(".fg-line").addClass("fg-toggled")
    }),
    $("audio, video")[0] && $("video,audio").mediaelementplayer(),
    $(".chosen")[0] && $(".chosen").chosen({
        width: "100%",
        allow_single_deselect: !0
    }),
    $(".input-slider")[0] && $(".input-slider").each(function() {
        var e = $(this).data("is-start");
        $(this).noUiSlider({
            start: e,
            range: {
                min: 0,
                max: 100
            }
        })
    }),
    $(".input-slider-range")[0] && $(".input-slider-range").noUiSlider({
        start: [30, 60],
        range: {
            min: 0,
            max: 100
        },
        connect: !0
    }),
    $(".input-slider-values")[0] && ($(".input-slider-values").noUiSlider({
        start: [45, 80],
        connect: !0,
        direction: "rtl",
        behaviour: "tap-drag",
        range: {
            min: 0,
            max: 100
        }
    }),
    $(".input-slider-values").Link("lower").to($("#value-lower")),
    $(".input-slider-values").Link("upper").to($("#value-upper"), "html")),
    $("input-mask")[0] && $(".input-mask").mask(),
    $(".date-time-picker")[0] && $(".date-time-picker").datetimepicker(),
    $(".time-picker")[0] && $(".time-picker").datetimepicker({
        format: "LT"
    }),
    $(".date-picker")[0] && $(".date-picker").datetimepicker({
        format: "DD/MM/YYYY"
    }),
    $(".form-wizard-basic")[0] && $(".form-wizard-basic").bootstrapWizard({
        tabClass: "fw-nav",
        nextSelector: ".next",
        previousSelector: ".previous"
    }),
    $(".lightbox")[0] && $(".lightbox").lightGallery({
        enableTouch: !0
    }),
    $("body").on("click", ".a-prevent", function(e) {
        e.preventDefault()
    }),
    $(".collapse")[0] && ($(".collapse").on("show.bs.collapse", function(e) {
        $(this).closest(".panel").find(".panel-heading").addClass("active")
    }),
    $(".collapse").on("hide.bs.collapse", function(e) {
        $(this).closest(".panel").find(".panel-heading").removeClass("active")
    }),
    $(".collapse.in").each(function() {
        $(this).closest(".panel").find(".panel-heading").addClass("active")
    })),
    $('[data-toggle="tooltip"]')[0] && $('[data-toggle="tooltip"]').tooltip(),
    $('[data-toggle="popover"]')[0] && $('[data-toggle="popover"]').popover(),
    $(".on-select")[0]) {
        var t = ".lv-avatar-content input:checkbox"
          , n = $(".on-select").closest(".lv-actions");
        $("body").on("click", t, function() {
            $(t + ":checked")[0] ? n.addClass("toggled") : n.removeClass("toggled")
        })
    }
    if ($("#ms-menu-trigger")[0] && $("body").on("click", "#ms-menu-trigger", function(e) {
        e.preventDefault(),
        $(this).toggleClass("open"),
        $(".ms-menu").toggleClass("toggled")
    }),
    $(".login-content")[0] && ($("html").addClass("login-content"),
    $("body").on("click", ".login-navigation > li", function() {
        var e = $(this).data("block")
          , t = $(this).closest(".lc-block");
        t.removeClass("toggled"),
        setTimeout(function() {
            $(e).addClass("toggled")
        })
    })),
    $('[data-action="fullscreen"]')[0]) {
        var a = $("[data-action='fullscreen']");
        a.on("click", function(e) {
            function t(e) {
                e.requestFullscreen ? e.requestFullscreen() : e.mozRequestFullScreen ? e.mozRequestFullScreen() : e.webkitRequestFullscreen ? e.webkitRequestFullscreen() : e.msRequestFullscreen && e.msRequestFullscreen()
            }
            e.preventDefault(),
            t(document.documentElement),
            a.closest(".dropdown").removeClass("open")
        })
    }
    if ($("[data-pmb-action]")[0] && $("body").on("click", "[data-pmb-action]", function(e) {
        e.preventDefault();
        var t = $(this).data("pmb-action");
        "edit" === t && $(this).closest(".pmb-block").toggleClass("toggled"),
        "reset" === t && $(this).closest(".pmb-block").removeClass("toggled")
    }),
    $("html").hasClass("ie9") && $("input, textarea").placeholder({
        customClass: "ie9-placeholder"
    }),
    $(".lvh-search-trigger")[0] && ($("body").on("click", ".lvh-search-trigger", function(e) {
        e.preventDefault(),
        x = $(this).closest(".lv-header-alt").find(".lvh-search"),
        x.fadeIn(300),
        x.find(".lvhs-input").focus()
    }),
    $("body").on("click", ".lvh-search-close", function() {
        x.fadeOut(300),
        setTimeout(function() {
            x.find(".lvhs-input").val("")
        }, 350)
    })),
    $('[data-action="print"]')[0] && $("body").on("click", '[data-action="print"]', function(e) {
        e.preventDefault(),
        window.print()
    }),
    $(".typeahead")[0]) {
        var i = ["Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming"]
          , o = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: i
        });
        $(".typeahead").typeahead({
            hint: !0,
            highlight: !0,
            minLength: 1
        }, {
            name: "states",
            source: o
        })
    }
    if ($(".wcc-toggle")[0]) {
        var s = '<div class="wcc-inner"><textarea class="wcci-text auto-size" placeholder="Write Something..."></textarea></div><div class="m-t-15"><button class="btn btn-sm btn-primary">Post</button><button class="btn btn-sm btn-link wcc-cencel">Cancel</button></div>';
        $("body").on("click", ".wcc-toggle", function() {
            $(this).parent().html(s),
            autosize($(".auto-size"))
        }),
        $("body").on("click", ".wcc-cencel", function(e) {
            e.preventDefault(),
            $(this).closest(".wc-comment").find(".wcc-inner").addClass("wcc-toggle").html("Write Something...")
        })
    }
    $("form.keyboard-save").keypress(function(e) {
        var t = navigator.appVersion.indexOf("Mac") != -1;
        if (t) {
            if ((115 != e.which || !e.metaKey || e.ctrlKey) && 19 != e.which)
                return !0
        } else if ((115 != e.which || !e.ctrlKey) && 19 != e.which)
            return !0;
        return this.submit(),
        e.preventDefault(),
        !1
    })
}),
function(e, t, n, a) {
    var i = "growl"
      , o = {
        element: "body",
        type: "info",
        allow_dismiss: !0,
        placement: {
            from: "top",
            align: "right"
        },
        offset: 20,
        spacing: 10,
        z_index: 1031,
        delay: 5e3,
        timer: 1e3,
        url_target: "_blank",
        mouse_over: !1,
        animate: {
            enter: "animated fadeInDown",
            exit: "animated fadeOutUp"
        },
        onShow: null,
        onShown: null,
        onHide: null,
        onHidden: null,
        icon_type: "class",
        template: '<div data-growl="container" class="alert" role="alert"><button type="button" aria-hidden="true" class="close" data-growl="dismiss">&times;</button><span data-growl="icon"></span><span data-growl="title"></span><span data-growl="message"></span><a href="#" data-growl="url"></a></div>'
    }
      , s = function(t, n) {
        o = e.extend(!0, {}, o, n)
    }
      , l = function(t) {
        t ? e('[data-growl="container"][data-growl-position="' + t + '"]').find('[data-growl="dismiss"]').trigger("click") : e('[data-growl="container"]').find('[data-growl="dismiss"]').trigger("click")
    }
      , r = function(t, n, a) {
        var n = {
            content: {
                message: "object" == typeof n ? n.message : n,
                title: n.title ? n.title : null,
                icon: n.icon ? n.icon : null,
                url: n.url ? n.url : null
            }
        };
        a = e.extend(!0, {}, n, a),
        this.settings = e.extend(!0, {}, o, a),
        plugin = this,
        d(a, this.settings, plugin),
        this.$template = $template
    }
      , d = function(e, t, n) {
        var a = {
            settings: t,
            element: t.element,
            template: t.template
        };
        "number" == typeof t.offset && (t.offset = {
            x: t.offset,
            y: t.offset
        }),
        $template = c(a),
        g($template, a.settings),
        u($template, a.settings),
        m($template, a.settings, n)
    }
      , c = function(t) {
        var n = e(t.settings.template);
        return n.addClass("alert-" + t.settings.type),
        n.attr("data-growl-position", t.settings.placement.from + "-" + t.settings.placement.align),
        n.find('[data-growl="dismiss"]').css("display", "none"),
        n.removeClass("alert-dismissable"),
        t.settings.allow_dismiss && (n.addClass("alert-dismissable"),
        n.find('[data-growl="dismiss"]').css("display", "block")),
        n
    }
      , g = function(e, t) {
        e.find('[data-growl="dismiss"]').css({
            "z-index": t.z_index - 1 >= 1 ? t.z_index - 1 : 1
        }),
        t.content.icon && ("class" == t.icon_type.toLowerCase() ? e.find('[data-growl="icon"]').addClass(t.content.icon) : e.find('[data-growl="icon"]').is("img") ? e.find('[data-growl="icon"]').attr("src", t.content.icon) : e.find('[data-growl="icon"]').append('<img src="' + t.content.icon + '" />')),
        t.content.title && e.find('[data-growl="title"]').html(t.content.title),
        t.content.message && e.find('[data-growl="message"]').html(t.content.message),
        t.content.url && (e.find('[data-growl="url"]').attr("href", t.content.url).attr("target", t.url_target),
        e.find('[data-growl="url"]').css({
            position: "absolute",
            top: 0,
            left: 0,
            width: "100%",
            height: "100%",
            "z-index": t.z_index - 2 >= 1 ? t.z_index - 2 : 1
        }))
    }
      , u = function(t, n) {
        var a = n.offset.y
          , i = {
            position: "body" === n.element ? "fixed" : "absolute",
            margin: 0,
            "z-index": n.z_index,
            display: "inline-block"
        }
          , o = !1;
        switch (e('[data-growl-position="' + n.placement.from + "-" + n.placement.align + '"]').each(function() {
            return a = Math.max(a, parseInt(e(this).css(n.placement.from)) + e(this).outerHeight() + n.spacing)
        }),
        i[n.placement.from] = a + "px",
        t.css(i),
        n.onShow && n.onShow(event),
        e(n.element).append(t),
        n.placement.align) {
        case "center":
            t.css({
                left: "50%",
                marginLeft: -(t.outerWidth() / 2) + "px"
            });
            break;
        case "left":
            t.css("left", n.offset.x + "px");
            break;
        case "right":
            t.css("right", n.offset.x + "px")
        }
        t.addClass("growl-animated"),
        t.one("webkitAnimationStart oanimationstart MSAnimationStart animationstart", function(e) {
            o = !0
        }),
        t.one("webkitAnimationEnd oanimationend MSAnimationEnd animationend", function(e) {
            n.onShown && n.onShown(e)
        }),
        setTimeout(function() {
            o || n.onShown && n.onShown(event)
        }, 600)
    }
      , m = function(e, t, n) {
        if (e.addClass(t.animate.enter),
        e.find('[data-growl="dismiss"]').on("click", function() {
            n.close()
        }),
        e.on("mouseover", function(t) {
            e.addClass("hovering")
        }).on("mouseout", function() {
            e.removeClass("hovering")
        }),
        t.delay >= 1) {
            e.data("growl-delay", t.delay);
            var a = setInterval(function() {
                var i = parseInt(e.data("growl-delay")) - t.timer;
                (!e.hasClass("hovering") && "pause" == t.mouse_over || "pause" != t.mouse_over) && e.data("growl-delay", i),
                i <= 0 && (clearInterval(a),
                n.close())
            }, t.timer)
        }
    };
    r.prototype = {
        update: function(e, t) {
            switch (e) {
            case "icon":
                "class" == this.settings.icon_type.toLowerCase() ? (this.$template.find('[data-growl="icon"]').removeClass(this.settings.content.icon),
                this.$template.find('[data-growl="icon"]').addClass(t)) : this.$template.find('[data-growl="icon"]').is("img") ? this.$template.find('[data-growl="icon"]') : this.$template.find('[data-growl="icon"]').find("img").attr().attr("src", t);
                break;
            case "url":
                this.$template.find('[data-growl="url"]').attr("href", t);
                break;
            case "type":
                this.$template.removeClass("alert-" + this.settings.type),
                this.$template.addClass("alert-" + t);
                break;
            default:
                this.$template.find('[data-growl="' + e + '"]').html(t)
            }
            return this
        },
        close: function() {
            var t = this.$template
              , n = this.settings
              , a = t.css(n.placement.from)
              , i = !1;
            return n.onHide && n.onHide(event),
            t.addClass(this.settings.animate.exit),
            t.nextAll('[data-growl-position="' + this.settings.placement.from + "-" + this.settings.placement.align + '"]').each(function() {
                e(this).css(n.placement.from, a),
                a = parseInt(a) + n.spacing + e(this).outerHeight()
            }),
            t.one("webkitAnimationStart oanimationstart MSAnimationStart animationstart", function(e) {
                i = !0
            }),
            t.one("webkitAnimationEnd oanimationend MSAnimationEnd animationend", function(t) {
                e(this).remove(),
                n.onHidden && n.onHidden(t)
            }),
            setTimeout(function() {
                i || (t.remove(),
                n.onHidden && n.onHidden(event))
            }, 100),
            this
        }
    },
    e.growl = function(e, t) {
        if (0 == e && "closeAll" == t.command)
            return l(t.position),
            !1;
        if (0 == e)
            return s(this, t),
            !1;
        var n = new r(this,e,t);
        return n
    }
}(jQuery, window, document);

