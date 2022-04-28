var stage = 0; //number of symbol in the password
var user = "";
var userPass = "";


function toggleDiv(id, show) {
    if (show) {
        document.getElementById(id).style.visibility = "visible";
    } else {
        document.getElementById(id).style.visibility = "hidden";
    }
}

function login() {
    toggleDiv("result", false);
    if (stage == 0) {
        setStage(0);
        user = document.getElementById("userId").value;
        if (!user || 0 === user.length) return;
        dojo.xhrPost({
            content: {
                t: "i",
                u: user
            },
            url: "gplProcessor.php",
            preventCache: true
        });
        setStage(1);
    } else {
        setStage(0);
        toggleDiv("result", true);
        
        dojo.byId("result").src = "gplProcessor.php?t=c&u=" + user + "&m=" + (new Date()).getTime();
    }
}

//gplProcessor.php?t=r&u=user&p=pos&s=stage Password input
function regClick(pos) {
    if (stage == 0) return;
    dojo.xhrPost({
        content: {
            t: "r",
            u: user,
            p: pos,
            s: stage
        },
        url: "gplProcessor.php",
        preventCache: true
    });
    setStage(++stage);
}

function setStage(s) {
    stage = s;
    if (!user || 0 === user.length) stage = 0;
    toggleDiv("imageTable", stage != 0);
    dojo.byId("userId").readOnly = (stage != 0);
    dojo.byId("curPass").innerHTML = "";
    if (stage == 0) return;

    dojo.byId("curPass").innerHTML = Array(stage).join("*") + "?";
    for (i = 1; i < 5; i++) {
        dojo.byId("image" + i).src = "gplProcessor.php?t=g&s=" + s + "&p=" + i + "&u=" + user;
    }
}

function add2pass(ind) {

    if (userPass.length != 0) userPass += ",";
    userPass += ind;
    dojo.place(dojo.toDom("<button id=\"pswInd" + ind + "\"><image class=\"btnClass\" src=\"gplProcessor.php?t=p&n=" + ind + "\"/>"), "enteredPass", "last");
}

function enterPass() {

    if (stage == 0) {
        setNewUserStage(0);
        user = document.getElementById("userId").value;
        refreshImages();
        setNewUserStage(1);
    }
}

function clearEnteredPass() {

    userPass = "";
    document.getElementById("enteredPass").innerHTML = "";
}


//Lock userID field if it is not empty and make visible pictures for password
function setNewUserStage(st) {

    stage = st;
    if (!user || 0 === user.length) stage = 0;
    document.getElementById("userId").readOnly = (stage != 0);
    toggleDiv("passTable", stage != 0);
    if (stage == 0) clearEnteredPass();
}

function backLast() {

    if (0 === user.length) return;
    var lastInd = userPass.split(",").pop();
    if (lastInd.length != 0) {
        dojo.destroy("pswInd" + lastInd);
        userPass = userPass.replace("," + lastInd, "");
    }
}

function saveUser() {

    if (0 === user.length) return;
    if (0 === userPass.length) return;
    dojo.xhrPost({
        content: {
            t: "a",
            u: user,
            p: userPass
        },
        url: "gplProcessor.php",
        load: function (data) {
            alert(data);
        },
        preventCache: true
    });
    user = "";
    userPass = "";
    setNewUserStage(0);
}

function refreshImages() {
    dojo.xhrPost({
        content: {
            t: "y"
        },
        url: "gplProcessor.php",
        preventCache: true
    });
    clearEnteredPass();

    dojo.query(".imgBtnClass").forEach(function (node, index, arr) {
        node.src = node.src;
    });
}


         
