<?php

    $songquery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
    $resultarray = array();
    while($row = mysqli_fetch_array($songquery))
    {
        array_push($resultarray, $row['id']);
    }

    $jsonarray = json_encode($resultarray);

?>

    <script>
        $(document).ready(function () {
            var newplaylist = <?php echo $jsonarray; ?>;
            audioelement = new Audio();
            settrack(newplaylist[0], newplaylist, false);
            updatevolumeprogressbar(audioelement.audio);

            $("#nowplayingbarcontainer").on("mousedown touchstart mousemove touchmove", function (e) {
                e.preventDefault();
            });

            $(".playbackbar .progressbar").mousedown(function () {
                mouseDown = true;
            });

            $(".playbackbar .progressbar").mousemove(function (e) {
                if (mouseDown) {
                    timefromoffset(e, this);
                }
            });
            $(".playbackbar .progressbar ").mouseup(function (e) {
                timefromoffset(e, this);

            });


            $(".volumebar .progressbar").mousedown(function () {
                mouseDown = true;
            });

            $(".volumebar .progressbar").mousemove(function (e) {
                if (mouseDown) {
                    var percentage = e.offsetX / $(this).width();


                    if (percentage >= 0 && percentage <= 1) {
                        audioelement.audio.volume = percentage;
                    }
                }
            });
            $(".volumebar .progressbar").mouseup(function (e) {
                var percentage = e.offsetX / $(this).width();
                if (percentage >= 0 && percentage <= 1) {
                    audioelement.audio.volume = percentage;
                }

            });

            $(document).mouseup(function () {
                mouseDown = false;
            });

        });

        function timefromoffset(mouse, progressbar) {
            var percentage = mouse.offsetX / $(progressbar).width() * 100;
            var seconds = audioelement.audio.duration * (percentage / 100);
            audioelement.settime(seconds);
        }

        function prevsong() {
            if (audioelement.audio.currentTime >= 3 || currentindex == 0) {
                audioelement.settime(0);
            } else {
                currentindex--;
                settrack(currentplaylist[currentindex], currentplaylist, true);
            }
        }

        function nextsong() {
            if (repeat == true) {
                audioelement.settime[0];
                playsong();
                return;
            }
            if (currentindex == currentplaylist.length - 1) {
                currentplaylist = 0;
            } else {
                currentindex++;
            }
            var tracktoplay = shuffle ? shuffleplaylist[currentindex] : currentplaylist[currentindex];
            settrack(tracktoplay, currentplaylist, true);

        }

        function setrepeat() {
            repeat = !repeat;
            var imagename = repeat ? "https://png.icons8.com/android/50/1566c2/repeat.png" :
                "https://png.icons8.com/android/50/ffffff/repeat.png";
            $(".controlbuttons.repeat img").attr("src", imagename);

        }

        function setmute() {
            audioelement.audio.muted = !audioelement.audio.muted;
            var imagename = audioelement.audio.muted ? "https://png.icons8.com/ios/50/1566c2/mute-filled.png" :
                "https://png.icons8.com/android/50/1566c2/speaker.png";
            $(".controlbuttons.volume img").attr("src", imagename);

        }


        function setshuffle() {
            shuffle = !shuffle;
            var imagename = shuffle ? "https://png.icons8.com/android/50/1566c2/shuffle.png" :
                "https://png.icons8.com/android/50/ffffff/shuffle.png";
            $(".controlbuttons.shuffle img").attr("src", imagename);

            if (shuffle) {
                shufflearray(shuffleplaylist);
                currentindex = shuffleplaylist.indexOf(audioelement.currentplaying.id);
            } else {
                currentindex = currentplaylist.indexOf(audioelement.currentplaying.id);
            }


        }

        function shufflearray(a) {
            var j, x, i;
            for (i = a.length - 1; i > 0; i--) {
                j = Math.floor(Math.random() * (i + 1));
                x = a[i];
                a[i] = a[j];
                a[j] = x;
            }
        }

        function settrack(trackid, newplaylist, play) {

            if (newplaylist != currentplaylist) {
                currentplaylist = newplaylist;
                shuffleplaylist = currentplaylist.slice();
                shufflearray(shuffleplaylist);
            }

            if (shuffle) {
                currentindex = shuffleplaylist.indexOf(trackid);
            } else {
                currentindex = currentplaylist.indexOf(trackid);

            }

            pausesong();

            $.post("includes/handlers/ajax/getsongjson.php", {
                songid: trackid
            }, function (data) {


                var track = JSON.parse(data);
                // console.log(track);
                // console.log(track.title);
                $(".trackname span").text(track.title);

                $.post("includes/handlers/ajax/getartistjson.php", {
                    artistid: track.artist
                }, function (data) {
                    var artist = JSON.parse(data)
                    $(".trackinfo .artistname span").text(artist.name);
                    $(".trackinfo .artistname span").attr("onclick", "openpage('artist.php?id=" + artist.id + "')");


                });

                $.post("includes/handlers/ajax/getalbumjson.php", {
                    albumid: track.album
                }, function (data) {
                    var album = JSON.parse(data)
                    $(".content .albumartwork").attr("src", album.artworkpath);
                    $(".content .albumartwork ").attr("onclick", "openpage('album.php?id=" + album.id + "')");
                    $(".trackinfo .trackname span").attr("onclick", "openpage('album.php?id=" + album.id + "')");




                });

                audioelement.settrack(track);
                if (play) {
                    playsong();
                }

            });


        }

        function playsong() {

            if (audioelement.audio.currentTime == 0) {
                $.post("includes/handlers/ajax/updateplays.php", {
                    songid: audioelement.currentlyplaying.id
                });
            }

            $(".controlbuttons.play").hide();
            $(".controlbuttons.pause").show();

            audioelement.play();
        }

        function pausesong() {
            $(".controlbuttons.pause").hide();
            $(".controlbuttons.play").show();
            audioelement.pause();
        }
    </script>

    <div id="nowplayingbarcontainer">
        <div id="nowplayingbar">
            <div id="nowplayingleft">
                <div class="content">
                    <span class="albumlink">
                        <img role="link" tabindex="0" class="albumartwork" src="" alt="Album">
                    </span>
                    <div class="trackinfo">
                        <span class="trackname">
                            <span role="link" tabindex="0"></span>
                        </span>
                        <span class="artistname">
                            <span role="link" tabindex="0"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div id="nowplayingcenter">
                <div class="content playercontrols">
                    <div class="buttons">
                        <button class="controlbuttons shuffle" title="Shuffle" onclick="setshuffle()">

                            <img src="https://png.icons8.com/android/50/ffffff/shuffle.png" alt="shuffle">
                        </button>
                        <button class="controlbuttons previous" title="Previous" onclick="prevsong()">

                            <img src="https://png.icons8.com/android/50/1566c2/rewind.png" alt="previous">
                        </button>
                        <button class="controlbuttons play" title="Play" onclick="playsong()">

                            <img src="https://png.icons8.com/android/50/1566c2/play.png" alt="play">
                        </button>
                        <button class="controlbuttons pause" title="Pause" style="display: none;" onclick="pausesong()">

                            <img src="https://png.icons8.com/android/50/1566c2/pause.png" alt="pause">
                        </button>
                        <button class="controlbuttons next" title="Next" onclick="nextsong()">

                            <img src="https://png.icons8.com/android/50/1566c2/end.png" alt="next">
                        </button>
                        <button class="controlbuttons repeat" title="Repeat" onclick="setrepeat()">

                            <img src="https://png.icons8.com/android/50/ffffff/repeat.png" alt="repeat">
                        </button>

                    </div>
                    <div class="playbackbar">
                        <span class="progresstime current">0:00</span>
                        <div class="progressbar">
                            <div class="progressbarbg">
                                <div class="progress"></div>
                            </div>
                        </div>
                        <span class="progresstime remaining">0:00</span>
                    </div>
                </div>
            </div>
            <div id="nowplayingright">
                <div class="volumebar">
                    <button class="controlbuttons volume" title="Volume" onclick="setmute()">
                        <img src="https://png.icons8.com/android/50/1566c2/speaker.png" alt="volume">
                    </button>
                    <div class="progressbar">
                        <div class="progressbarbg">
                            <div class="progress"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>