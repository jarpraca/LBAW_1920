function addEventListeners() {
    $('body').tooltip({
        selector: '[data-toggle="tooltip"]'
    });

    let form = document.querySelector(".editAuction");
    if (form != null) {
        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("id", "force_edit");
        input.setAttribute("value", 1);
        form.appendChild(input);
    }

    let imageDeleters = document.querySelectorAll(".editAuction a.image_delete");
    [].forEach.call(imageDeleters, function (deleter) {
        deleter.addEventListener("click", sendDeleteImageRequest);
    });

    let stopButton = document.querySelector("#stop_button");
    if (stopButton != null)
        stopButton.addEventListener("click", disableStopAuctionButton);

    let methodButton = document.querySelector('#method_button');
    if (methodButton != null)
        methodButton.addEventListener("click", saveMethods)

    let addwatchlistButton = document.querySelector(".addWatchlist");
    if (addwatchlistButton != null)
        addwatchlistButton.addEventListener("click", addToWatchlistButton);

    let remwatchlistButton = document.querySelector(".remWatchlist");
    if (remwatchlistButton != null)
        remwatchlistButton.addEventListener("click", remToWatchlistButton);

    let addwatchlistEye = document.querySelectorAll(".addWatchlistEye");
    [].forEach.call(addwatchlistEye, function (eye) {
        eye.addEventListener("click", addToWatchlistEye);
    });

    let remwatchlistEye = document.querySelectorAll(".remWatchlistEye");
    [].forEach.call(remwatchlistEye, function (eye) {
        eye.addEventListener("click", remToWatchlistEye);
    });

    let reportAuction = document.querySelectorAll(".report_auction_confirm");
    [].forEach.call(reportAuction, function (eye) {
        eye.addEventListener("click", reportAuctionEye);
    });

    addListenerPageReports();
    addListenerPageUsers();
    addListenerApproveReport();
    addListenerBlockDeleteUser();

    addAuctionCountdown();
}

function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data)
        .map(function (k) {
            return encodeURIComponent(k) + "=" + encodeURIComponent(data[k]);
        })
        .join("&");
}

function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();

    request.open(method, url, true);
    request.setRequestHeader(
        "X-CSRF-TOKEN",
        document.querySelector('meta[name="csrf-token"]').content
    );
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.addEventListener("load", handler);
    request.send(encodeForAjax(data));
}

function sendDeleteImageRequest() {
    let input = document.querySelector(".editAuction #force_edit");
    input.setAttribute('value', 3);
    console.log(input.getAttribute('value'));
    let id = this.getAttribute("data-id");
    console.log(id);
    sendAjaxRequest("delete", "/api/images/" + id, null, imageDeletedHandler);
}

function imageDeletedHandler() {
    if (this.status != 200)
        console.log(this);
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('a[data-id="' + item.id + '"]');
    element.remove();
}

function disableStopAuctionButton() {
    let id = this.getAttribute("data-id");
    sendAjaxRequest("put", "/api/auctions/" + id + "/stop", null, stopAuctionHandler);
}

function stopAuctionHandler() {
    let stop_button = document.querySelector("#stop_button");
    stop_button.remove();
}

function saveMethods() {
    let payMethodSelect = document.querySelector('#pay_method');
    let shipMethodSelect = document.querySelector('#ship_method');
    let pay_method = payMethodSelect.options[payMethodSelect.selectedIndex].value;
    let ship_method = shipMethodSelect.options[shipMethodSelect.selectedIndex].value;
    let data = { payM: pay_method, shipM: ship_method };

    console.log(pay_method);
    console.log(ship_method);
    //sendAjaxRequest("put", 'api/auctions/' + idk man + '/choose_methods', data, methodSelectionHandler);
}

function methodSelectionHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let close_button = document.querySelector('.moder-header button');
    close_button.click();
}

function addToWatchlistButton() {
    let id_auction = this.getAttribute("data-id");
    sendAjaxRequest("post", "/api/watchlists/" + id_auction, null, addToWatchlistHandler);
}

function addToWatchlistHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let button = document.querySelector('.addWatchlist');
    button.classList.remove("addWatchlist");
    button.classList.add("remWatchlist");
    button.innerHTML = "Remove from Watchlist";
    button.removeEventListener("click", addToWatchlistButton);
    button.addEventListener("click", remToWatchlistButton);
}

function remToWatchlistButton() {
    let id_auction = this.getAttribute("data-id");
    sendAjaxRequest("delete", "/api/watchlists/" + id_auction, null, remToWatchlistHandler);
}

function remToWatchlistHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let button = document.querySelector('.remWatchlist');
    button.classList.remove("remWatchlist");
    button.classList.add("addWatchlist");
    button.innerHTML = "Add to Watchlist";
    button.removeEventListener("click", remToWatchlistButton);
    button.addEventListener("click", addToWatchlistButton);
}

function addToWatchlistEye(event) {
    event.preventDefault();
    let id_auction = this.getAttribute("data-id");
    sendAjaxRequest("post", "/api/watchlists/" + id_auction, null, addToWatchlistEyeHandler);
}

function addToWatchlistEyeHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    let buttons = document.querySelectorAll('.addWatchlistEye[data-id="' + id + '"]');
    [].forEach.call(buttons, function (button) {
        button.classList.remove("addWatchlistEye");
        button.classList.remove("far");
        button.classList.remove("colorGrey");
        button.classList.add("remWatchlistEye");
        button.classList.add("fas");
        button.classList.add("colorGreen");
        button.removeEventListener("click", addToWatchlistEye);
        button.addEventListener("click", remToWatchlistEye);
    });

    let watchlist = document.querySelector('#watchlist');
    if (watchlist != null) {
        let watchlist_list = document.querySelector('#watchlist div');
        let watchlist_card = document.querySelector('.auct-card-ref[data-id="' + id + '"]').cloneNode(true);
        if (watchlist_list != null) {
            watchlist_list.appendChild(watchlist_card);
        }
        else {
            let text = document.querySelector('#watchlist p')
            text.remove();
            let div = document.createElement("div");
            div.setAttribute("class", "d-flex flex-wrap text-left justify-flex-start");
            div.appendChild(watchlist_card);
            watchlist.appendChild(div);
        }
    }
}

function remToWatchlistEye(event) {
    event.preventDefault();
    let id_auction = this.getAttribute("data-id");
    sendAjaxRequest("delete", "/api/watchlists/" + id_auction, null, remToWatchlistEyeHandler);
}

function remToWatchlistEyeHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    let watchlist_card = document.querySelector('#watchlist .auct-card-ref[data-id="' + id + '"]');
    if (watchlist_card != null) {
        watchlist_card.remove();
        let watchlist = document.querySelector('#watchlist');
        if (watchlist != null) {
            let watchlist_list = document.querySelector('#watchlist div');
            if (watchlist_list != null && watchlist_list.childElementCount == 0) {
                watchlist.innerHTML = "";
                let text = document.createElement("p");
                text.setAttribute("class", "ml-3 mt-3");
                text.innerHTML = "You still haven't added any auctions to your watchlist";
                watchlist.appendChild(text);
            }
        }
    }

    let buttons = document.querySelectorAll('.remWatchlistEye[data-id="' + id + '"]');
    [].forEach.call(buttons, function (button) {
        button.classList.remove("remWatchlistEye");
        button.classList.remove("fas");
        button.classList.remove("colorGreen");
        button.classList.add("addWatchlistEye");
        button.classList.add("far");
        button.classList.add("colorGrey");
        button.removeEventListener("click", remToWatchlistEye);
        button.addEventListener("click", addToWatchlistEye);
    });
}

function reportAuctionEye(event) {
    event.preventDefault();
    let id_auction = this.getAttribute("data-id");
    let description = document.querySelector("#description");
    let data = {description: description.value};
    url = "/api/auctions/" + id_auction + "/report";
    sendAjaxRequest("post", url, data, reportAuctionEyeHandler);
}

function reportAuctionEyeHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let message = JSON.parse(this.responseText);
    let closeModal = document.querySelector('.report_auction_cancel');
    closeModal.click();
    let alert = document.querySelector("#alert");
    alert.classList.remove("alert-danger");
    alert.classList.remove("alert-success");
    alert.classList.add("alert-" + message.state);
    alert.innerHTML = message.data;
    alert.removeAttribute("hidden");
    if(message.state == "success"){
        var myVar;
        myVar = setTimeout(resetAlert, 2000);
    }
}

function alertFunc() {
    alert("Hello!");
  }

function resetAlert() {
    let alert = document.querySelector("#alert");
     alert.setAttribute("hidden","");
}

function addListenerPageReports() {
    let paginationReports = document.querySelectorAll(".reports .pagination a");
    [].forEach.call(paginationReports, function (page) {
        page.addEventListener("click", loadPageReports);
    });
}

function loadPageReports(event) {
    event.preventDefault();
    let url = this.getAttribute('href');
    let page = url.split("page=")[1];
    url = "api/reports?page=" + page;
    sendAjaxRequest("get", url, null, pageReportsHandler);
}

function pageReportsHandler() {
    if (this.status != 200)
        console.log(this);
    let element = document.querySelector('.reports');
    element.innerHTML = this.responseText;
    document.querySelector('#reports').scrollIntoView();
    addListenerPageReports();
    addListenerApproveReport();
}

function addListenerPageUsers() {
    let paginationUsers = document.querySelectorAll(".users .pagination a");
    [].forEach.call(paginationUsers, function (page) {
        page.addEventListener("click", loadPageUsers);
    });
}

function loadPageUsers(event) {
    event.preventDefault();
    let url = this.getAttribute('href');
    let page = url.split("page=")[1];
    url = "api/users?page=" + page;
    sendAjaxRequest("get", url, null, pageUsersHandler);
}

function pageUsersHandler() {
    if (this.status != 200)
        console.log(this);
    let element = document.querySelector('.users');
    element.innerHTML = this.responseText;
    document.querySelector('#users').scrollIntoView();
    addListenerPageUsers();
    addListenerBlockDeleteUser();
}

function addListenerApproveReport() {
    let accept = document.querySelectorAll(".accept_report");
    [].forEach.call(accept, function (button) {
        button.addEventListener("click", acceptReport);
    });

    let deny = document.querySelectorAll(".deny_report");
    [].forEach.call(deny, function (button) {
        button.addEventListener("click", denyReport);
    });
}

function acceptReport(event) {
    event.preventDefault();
    let id = this.getAttribute('data-id');
    url = "api/reports/" + id + "/" + 1;
    sendAjaxRequest("put", url, null, acceptReportHandler);
}

function acceptReportHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    let status = document.querySelector('.report[data-id="' + id + '"] span');
    status.classList.remove('badge-warning');
    status.classList.add('badge-success');
    status.innerHTML = "Approved";
    let action = document.querySelector('.report[data-id="' + id + '"] td:last-child');
    action.innerHTML = "";
}

function denyReport(event) {
    event.preventDefault();
    let id = this.getAttribute('data-id');
    url = "api/reports/" + id + "/" + 2;
    sendAjaxRequest("put", url, null, denyReportHandler);
}

function denyReportHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    console.log(this.responseText);
    let id = JSON.parse(this.responseText);
    let status = document.querySelector('.report[data-id="' + id + '"] span');
    status.classList.remove('badge-warning');
    status.classList.add('badge-danger');
    status.innerHTML = "Denied";
    let action = document.querySelector('.report[data-id="' + id + '"] td:last-child');
    action.innerHTML = "";
}

function addListenerBlockDeleteUser() {
    let unblock = document.querySelectorAll(".unblock_button");
    [].forEach.call(unblock, function (button) {
        button.addEventListener("click", unblockUser);
    });

    let block = document.querySelectorAll(".block_button");
    [].forEach.call(block, function (button) {
        button.addEventListener("click", blockUser);
    });

    let delete_user = document.querySelectorAll(".delete_user_confirm");
    [].forEach.call(delete_user, function (button) {
        button.addEventListener("click", deleteUser);
    });
}

function unblockUser(event) {
    event.preventDefault();
    let id = this.getAttribute('data-id');
    url = "api/users/" + id + "/unblock";
    sendAjaxRequest("post", url, null, unblockUserHandler);
}

function unblockUserHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    let button = document.querySelector('.unblock_button[data-id="' + id + '"]');
    button.className = "btn btn-warning block_button";
    button.innerHTML = "Block";
    button.removeEventListener("click", unblockUser);
    button.addEventListener("click", blockUser);
}

function blockUser(event) {
    event.preventDefault();
    let id = this.getAttribute('data-id');
    url = "api/users/" + id + "/block";
    sendAjaxRequest("post", url, null, blockUserHandler);
}

function blockUserHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    let button = document.querySelector('.block_button[data-id="' + id + '"]');
    button.className = "btn btn-success unblock_button";
    button.innerHTML = "Unblock";
    button.removeEventListener("click", blockUser);
    button.addEventListener("click", unblockUser);
}

function deleteUser(event) {
    event.preventDefault();
    let id = this.getAttribute('data-id');
    url = "api/users/" + id;
    sendAjaxRequest("delete", url, null, deleteUserHandler);
}

function deleteUserHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    let closeModal = document.querySelector('.delete_user_cancel[data-id="' + id + '"]');
    closeModal.click();
    // update pagination
    let page = document.querySelector('.user_list').getAttribute('data-id');
    let url = "api/users?page=" + page;
    sendAjaxRequest("get", url, null, pageUsersHandler);
}

function addAuctionCountdown() {
    let countdown = document.getElementById("countdown");
    if (countdown != null) {
        let date = countdown.getAttribute('data-id').replace(/-/g, '/');
        let countDownDate = new Date(date + ' +0100').getTime();
        updateCountdown(countdown, countDownDate);

        setInterval(() => {
            updateCountdown(countdown, countDownDate);
        }, 1000);
    }
}

function updateCountdown(countdown, countDownDate) {
    // Get today's date and time
    let now = new Date().getTime();

    // Find the distance between now and the count down date
    let distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    if (days != 0)
        countdown.innerHTML = days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ";
    else if (hours != 0)
        countdown.innerHTML = hours + "h "
            + minutes + "m " + seconds + "s ";
    else if (minutes != 0)
        countdown.innerHTML = minutes + "m " + seconds + "s ";
    else
        countdown.innerHTML = seconds + "s ";

    // If the count down is finished, write some text
    if (distance < 0) {
        location.reload();
    }
}

// function fb_login(){
//     FB.login(function(response) {

//         if (response.authResponse) {
//             console.log('Welcome!  Fetching your information.... ');
//             //console.log(response); // dump complete info
//             access_token = response.authResponse.accessToken; //get access token
//             user_id = response.authResponse.userID; //get FB UID

//             FB.api('/me', function(response) {
//                 user_email = response.email; //get user email
//           // you can store this data into your database             
//             });

//         } else {
//             //user hit cancel button
//             console.log('User cancelled login or did not fully authorize.');

//         }
//     }, {
//         scope: 'public_profile,email'
//     });
// }

addEventListeners();
