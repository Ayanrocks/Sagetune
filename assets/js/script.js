var currentplaylist = [];
var shuffleplaylist = [];
var tempplaylist = [];
var audioelement;
var mouseDown = false;
var currentindex = 0;
var repeat = false;
var shuffle = false;
var userloggedin;
var timer;

$(document).bind("contextmenu", function (e) {
    e.preventDefault();
});
$(document).keydown(function (e) {
    if (e.which === 123) {
        return false;
    }
});
document.onkeydown = function (e) {

    if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
        return false;
    }
    if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
        return false;
    }
}


$(document).click(function (click) {
    var target = $(click.target);
    if (!target.hasClass("item") && !target.hasClass("optionbutton")) {
        hideoptionmenu();
    }
});

$(document).on("change", "select.playlist", function () {
    var select = $(this);
    var playlistid = select.val();
    var songid = select.prev(".songid").val();
    $.post("includes/handlers/ajax/addtoplaylist.php", {
        playlistid: playlistid,
        songid: songid
    }).done(function (error) {
        if (error != "") {
            console.log( error);
            return;
        }
        
    });
    hideoptionmenu();
    select.val("");
});

$(window).scroll(function () {
    hideoptionmenu();
});

function openpage(url) {
    if (timer != null) {
        clearTimeout(timer);
    }
    if (url.indexOf("?") == -1) {
        url = url + "?";
    }
    var encodedurl = encodeURI(url + "&userLoggedIn=" + userloggedin);
    $("#maincontent").load(encodedurl);
    $("body").scrollTop(0);
    history.pushState(null, null, url)
}

function removefromplaylist(button, playlistid) {
    var songid = $(button).prevAll(".songid").val();
    $.post("includes/handlers/ajax/removefromplaylist.php", {
        playlistid: playlistid,
        songid : songid
    }).done(function (error) {
        if (error != "") {
            alert(error);
            return;
        }
        openpage("playlist.php?id=" + playlistid);

    });

}

function createplaylist() {
    var popup = prompt("Enter the Name of your Playlist");

    if (popup != null) {
        $.post("includes/handlers/ajax/createplaylist.php", {
            name: popup,
            username: userloggedin
        }).done(function (error) {
            if (error != "") {
                alert(error);
                return;
            }
            openpage("yourmusic.php");
        });
    }
}

function updateemail(emailClass) {
    var emailvalue = $("." + emailClass).val();

    $.post("includes/handlers/ajax/updateemail.php", {email : emailvalue, username: userloggedin}).done(function(response) {
        $("." + emailClass).nextAll(".message").text(response);
    })
}

function updatepassword(oldpasswordclass, newpasswordclass1, newpasswordclass2) {
    var oldpassword = $("." + oldpasswordclass).val();
    var newpassword1 = $("." + newpasswordclass1).val();
    var newpassword2 = $("." + newpasswordclass2).val();

    $.post("includes/handlers/ajax/updatepassword.php", {
        oldpassword: oldpassword,
        newpassword1: newpassword1,
        newpassword2: newpassword2,
        username: userloggedin
    }).done(function (response) {
        $("." + oldpasswordclass).nextAll(".message").text(response);
    })
}
function logout() {
    $.post("includes/handlers/ajax/logout.php", function(){
        location.reload();
    });
}

function deleteplaylist(playlistid) {
    var prompt = confirm("Are you sure you want to delete this playlist? This action cannot be undone")

    if (prompt) {
        $.post("includes/handlers/ajax/deleteplaylist.php", {
            playlistid: playlistid
        }).done(function (error) {
            if (error != "") {
                alert(error);
                return;
            }
            openpage("yourmusic.php");
        });
    }
}

function hideoptionmenu() {
    var menu = $("nav.optionsmenu");
    if (menu.css("display") != "none") {
        menu.css("display", "none");
    }
}

function showoptionmenu(button) {
    var songid = $(button).prevAll(".songid").val();
    var menu = $("nav.optionsmenu");
    var menuwidth = menu.width();
    menu.find(".songid").val(songid);
    var scrolltop = $(window).scrollTop();
    var elementoffset = $(button).offset().top;
    var top = elementoffset - scrolltop;
    var left = $(button).position().left;

    menu.css({
        "top": top + "px",
        "left": left - menuwidth + "px",
        "display": "inline"
    });


}

function formattime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60);
    var seconds = time - (minutes * 60);

    var extrazero
    if (seconds < 10) {
        extrazero = "0";
    } else {
        extrazero = "";
    }
    return minutes + ":" + extrazero + seconds;

}

function updatetimeprogressbar(audio) {
    $(".progresstime.current").text(formattime(audio.currentTime));
    $(".progresstime.remaining").text(formattime(audio.duration - audio.currentTime));

    var progress = audio.currentTime / audio.duration * 100;
    $(".playbackbar .progress").css("width", progress + "%");
}

function updatevolumeprogressbar(audio) {
    var volume = audio.volume * 100;
    $(".volumebar .progress").css("width", volume + "%");
}

function playfirstsong() {
    settrack(tempplaylist[0], tempplaylist, true);
}

function Audio() {
    this.currentlyplaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("ended", function () {
        nextsong();
    });

    this.audio.addEventListener("canplay", function () {
        var duration = formattime(this.duration);
        $(".progresstime.remaining").text(duration);

    });

    this.audio.addEventListener("timeupdate", function () {
        if (this.duration) {
            updatetimeprogressbar(this);
        }
    });

    this.audio.addEventListener("volumechange", function () {
        updatevolumeprogressbar(this);
    });

    this.settrack = function (track) {
        this.currentlyplaying = track;
        this.audio.src = track.path;
    }

    this.play = function () {
        this.audio.play();

    }

    this.pause = function () {
        this.audio.pause();
    }

    this.settime = function (seconds) {
        this.audio.currentTime = seconds;
    }
}