function addEventListeners() {
    $("body").tooltip({
        selector: '[data-toggle="tooltip"]',
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

    let biddingHistory = document.querySelector("#bidding_history");
    if (biddingHistory != null)
        biddingHistory.addEventListener("click", getBiddingHistory);

    let topBids = document.querySelector("#top_bids");
    if (topBids != null)
        setInterval(function () {
            getTopBids(topBids);
        }, 2000);

    let notifications = document.querySelector("#notification_bell");
    if (notifications != null) {
        notifications.addEventListener('click', getLastNotifications);
        hasUnreadNotifications(notifications);
        setInterval(function () {
            hasUnreadNotifications(notifications);
        }, 2000);
    }

    addListenerPageReports();
    addListenerPageUsers();
    addListenerApproveReport();
    addListenerBlockDeleteUser();

    addAuctionCountdown();

    imageUploads();
    deleteProfileImage();
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
    input.setAttribute("value", 3);
    console.log(input.getAttribute("value"));
    let id = this.getAttribute("data-id");
    console.log(id);
    sendAjaxRequest("delete", "/api/images/" + id, null, imageDeletedHandler);
}

function imageDeletedHandler() {
    if (this.status != 200) console.log(this);
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('a[data-id="' + item.id + '"]');
    element.remove();
}

function getBiddingHistory() {
    let id = this.getAttribute("data-id");
    sendAjaxRequest(
        "get",
        "/api/auctions/" + id + "/biddingHistory",
        null,
        biddingHistoryHandler
    );
}

function biddingHistoryHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let bidding_history = JSON.parse(this.responseText);
    let bidsList = document.querySelector("#bids_list");
    bidsList.innerHTML = "";

    [].forEach.call(bidding_history, function (bid) {
        if (bid.name == null) bid.name = "Deleted User";

        let div = document.createElement("div");
        div.setAttribute("class", "d-flex flex-row mb-0 bid_entry");

        let name = document.createElement("p");
        name.setAttribute("class", "w-50 text-left mb-0");
        name.innerHTML = bid.name;

        let value = document.createElement("p");
        value.setAttribute("class", "w-50 text-right mb-0");
        value.innerHTML = bid.value + " €";

        div.appendChild(name);
        div.appendChild(value);
        bidsList.appendChild(div);
    });
}

function getTopBids(button) {
    let id = button.getAttribute("data-id");
    sendAjaxRequest(
        "get",
        "/api/auctions/" + id + "/topBids",
        null,
        topBidsHandler
    );
}

function topBidsHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let top_bids = JSON.parse(this.responseText);
    if (top_bids.length == 0)
        return;
    let top_bids_div = document.querySelector("#top_bids");

    top_bids_div.innerHTML = "";

    [].forEach.call(top_bids, function (bid) {
        if (bid.name == null) bid.name = "Deleted User";

        let div = document.createElement("div");
        div.setAttribute("class", "d-flex flex-row mb-0 bid_entry");

        let name = document.createElement("p");
        name.setAttribute("class", "w-50 text-left mb-0");
        name.innerHTML = bid.name;

        let value = document.createElement("p");
        value.setAttribute("class", "w-50 text-right mb-0");
        value.innerHTML = bid.value + " €";

        div.appendChild(name);
        div.appendChild(value);
        top_bids_div.appendChild(div);
    });
}

function saveMethods() {
    let id = this.getAttribute("data-id_auction");
    let id_notif = this.getAttribute("data-id");
    let payMethodSelect = document.querySelector("#pay_method");
    let shipMethodSelect = document.querySelector("#ship_method");

    if (payMethodSelect.selectedIndex == "0" || shipMethodSelect.selectedIndex == "0") {
        let alert = document.querySelector("#alert_method");
        alert.classList.add("alert-danger");
        alert.innerHTML = "All inputs must be filled!";
        alert.style.display = "grid";
        alert.removeAttribute("hidden");
        return;
    }

    let pay_method = payMethodSelect.options[payMethodSelect.selectedIndex].value;
    let ship_method = shipMethodSelect.options[shipMethodSelect.selectedIndex].value;
    let data = { payM: pay_method, shipM: ship_method, id_notif: id_notif };

    sendAjaxRequest("put", '/api/auctions/' + id + '/choose_methods', data, methodSelectionHandler);
}

function methodSelectionHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);

    let alert = document.querySelector("#alert_method");
    if (alert.classList.contains("alert-danger"))
        alert.classList.remove("alert-danger");
    alert.style.display = "none";
    alert.setAttribute("hidden", true);

    let close = document.querySelector('#method_modal_cancel[data-id="' + id + '"]');
    close.click();
}

function saveRate() {
    let id = this.getAttribute("data-id_auction");
    let id_notif = this.getAttribute("data-id");
    let rating = parseInt(document.querySelector("#rating_value").value);

    if (rating < 1 || rating > 5) {
        let alert = document.querySelector("#alert_rate");
        alert.classList.add("alert-danger");
        alert.innerHTML = "Rating must be an integer between 1 and 5!";
        alert.style.display = "grid";
        alert.removeAttribute("hidden");
        return;
    }

    let data = { rating: rating, id_notif: id_notif };

    sendAjaxRequest("put", '/api/rates/' + id, data, saveRateHandler);
}

function saveRateHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    if (id == 0) {
        let alert = document.querySelector("#alert_rate");
        alert.classList.add("alert-danger");
        alert.innerHTML = "Rating must be an integer between 1 and 5!";
        alert.style.display = "grid";
        alert.removeAttribute("hidden");
    }
    else {
        let alert = document.querySelector("#alert_rate");
        if (alert.classList.contains("alert-danger"))
            alert.classList.remove("alert-danger");
        alert.style.display = "none";
        alert.setAttribute("hidden", true);

        let close = document.querySelector('#rate_modal_cancel[data-id="' + id + '"]');
        close.click();
    }
}

function addToWatchlistButton() {
    let id_auction = this.getAttribute("data-id");
    sendAjaxRequest(
        "post",
        "/api/watchlists/" + id_auction,
        null,
        addToWatchlistHandler
    );
}

function addToWatchlistHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let button = document.querySelector(".addWatchlist");
    button.classList.remove("addWatchlist");
    button.classList.add("remWatchlist");
    button.innerHTML = "Remove from Watchlist";
    button.removeEventListener("click", addToWatchlistButton);
    button.addEventListener("click", remToWatchlistButton);
}

function remToWatchlistButton() {
    let id_auction = this.getAttribute("data-id");
    sendAjaxRequest(
        "delete",
        "/api/watchlists/" + id_auction,
        null,
        remToWatchlistHandler
    );
}

function remToWatchlistHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let button = document.querySelector(".remWatchlist");
    button.classList.remove("remWatchlist");
    button.classList.add("addWatchlist");
    button.innerHTML = "Add to Watchlist";
    button.removeEventListener("click", remToWatchlistButton);
    button.addEventListener("click", addToWatchlistButton);
}

function addToWatchlistEye(event) {
    event.preventDefault();
    let id_auction = this.getAttribute("data-id");
    sendAjaxRequest(
        "post",
        "/api/watchlists/" + id_auction,
        null,
        addToWatchlistEyeHandler
    );
}

function addToWatchlistEyeHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    let buttons = document.querySelectorAll(
        '.addWatchlistEye[data-id="' + id + '"]'
    );
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

    let watchlist = document.querySelector("#watchlist");
    if (watchlist != null) {
        let watchlist_list = document.querySelector("#watchlist div");
        let watchlist_card = document
            .querySelector('.auct-card-ref[data-id="' + id + '"]')
            .cloneNode(true);
        if (watchlist_list != null) {
            watchlist_list.appendChild(watchlist_card);
        } else {
            let text = document.querySelector("#watchlist p");
            text.remove();
            let div = document.createElement("div");
            div.setAttribute(
                "class",
                "d-flex flex-wrap text-left justify-flex-start"
            );
            div.appendChild(watchlist_card);
            watchlist.appendChild(div);
        }
    }
}

function remToWatchlistEye(event) {
    event.preventDefault();
    let id_auction = this.getAttribute("data-id");
    sendAjaxRequest(
        "delete",
        "/api/watchlists/" + id_auction,
        null,
        remToWatchlistEyeHandler
    );
}

function remToWatchlistEyeHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    let watchlist_card = document.querySelector(
        '#watchlist .auct-card-ref[data-id="' + id + '"]'
    );
    if (watchlist_card != null) {
        watchlist_card.remove();
        let watchlist = document.querySelector("#watchlist");
        if (watchlist != null) {
            let watchlist_list = document.querySelector("#watchlist div");
            if (watchlist_list != null && watchlist_list.childElementCount == 0) {
                watchlist.innerHTML = "";
                let text = document.createElement("p");
                text.setAttribute("class", "ml-3 mt-3");
                text.innerHTML =
                    "You still haven't added any auctions to your watchlist";
                watchlist.appendChild(text);
            }
        }
    }

    let buttons = document.querySelectorAll(
        '.remWatchlistEye[data-id="' + id + '"]'
    );
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
    let data = { description: description.value };
    url = "/api/auctions/" + id_auction + "/report";
    sendAjaxRequest("post", url, data, reportAuctionEyeHandler);
}

function reportAuctionEyeHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let message = JSON.parse(this.responseText);
    let closeModal = document.querySelector(".report_auction_cancel");
    closeModal.click();

    let alert = document.querySelector("#alert");
    alert.classList.remove("alert-danger");
    alert.classList.remove("alert-success");
    alert.classList.add("alert-" + message.state);
    alert.style.display = "grid";
    alert.innerHTML = message.data;
    alert.removeAttribute("hidden");
    if(message.state == "success"){
        var myVar;
        myVar = setTimeout(resetAlert, 5000);
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
    let url = this.getAttribute("href");
    let page = url.split("page=")[1];
    url = "/api/reports?page=" + page;
    sendAjaxRequest("get", url, null, pageReportsHandler);
}

function pageReportsHandler() {
    if (this.status != 200)
        console.log(this);
    let element = document.querySelector(".reports");
    element.innerHTML = this.responseText;
    document.querySelector("#reports").scrollIntoView();
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
    let url = this.getAttribute("href");
    let page = url.split("page=")[1];
    url = "/api/users?page=" + page;
    sendAjaxRequest("get", url, null, pageUsersHandler);
}

function pageUsersHandler() {
    if (this.status != 200)
        console.log(this);
    let element = document.querySelector(".users");
    element.innerHTML = this.responseText;
    document.querySelector("#users").scrollIntoView();
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
    let id = this.getAttribute("data-id");
    let url = "/api/reports/" + id + "/" + 1;
    sendAjaxRequest("put", url, null, acceptReportHandler);
}

function acceptReportHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    let status = document.querySelector('.report[data-id="' + id + '"] span');
    status.classList.remove("badge-warning");
    status.classList.add("badge-success");
    status.innerHTML = "Approved";
    let action = document.querySelector(
        '.report[data-id="' + id + '"] td:last-child'
    );
    action.innerHTML = "";
    let close = document.querySelector(
        '.approve_report_cancel[data-id="' + id + '"]'
    );
    close.click();
}

function denyReport(event) {
    event.preventDefault();
    let id = this.getAttribute("data-id");
    let url = "/api/reports/" + id + "/" + 2;
    sendAjaxRequest("put", url, null, denyReportHandler);
}

function denyReportHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    let status = document.querySelector('.report[data-id="' + id + '"] span');
    status.classList.remove("badge-warning");
    status.classList.add("badge-danger");
    status.innerHTML = "Denied";
    let action = document.querySelector(
        '.report[data-id="' + id + '"] td:last-child'
    );
    action.innerHTML = "";
    let close = document.querySelector(
        '.approve_report_cancel[data-id="' + id + '"]'
    );
    close.click();
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
    let id = this.getAttribute("data-id");
    let url = "/api/users/" + id + "/unblock";
    sendAjaxRequest("post", url, null, unblockUserHandler);
}

function unblockUserHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let response = JSON.parse(this.responseText);
    console.log(response)
    let button = document.querySelector('.unblock_button[data-id="' + response.id + '"]');
    button.className = "btn btn-warning block_button";
    button.innerHTML = "Block";
    button.removeEventListener("click", unblockUser);
    button.addEventListener("click", blockUser);

    let alert = document.querySelector("#alert_admin");
    alert.innerHTML = response.user + " unblocked!";
    alert.classList.add("show");
    setTimeout(() => {
        alert.classList.remove("show");
    }, 2000);
}

function blockUser(event) {
    event.preventDefault();
    let id = this.getAttribute("data-id");
    let url = "/api/users/" + id + "/block";
    sendAjaxRequest("post", url, null, blockUserHandler);
}

function blockUserHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let response = JSON.parse(this.responseText);
    console.log(response);
    let button = document.querySelector('.block_button[data-id="' + response.id + '"]');
    button.className = "btn btn-success unblock_button";
    button.innerHTML = "Unblock";
    button.removeEventListener("click", blockUser);
    button.addEventListener("click", unblockUser);

    let alert = document.querySelector("#alert_admin");
    alert.innerHTML = response.user + " blocked!";
    alert.classList.add("show");
    setTimeout(() => {
        alert.classList.remove("show");
    }, 2000);
}

function deleteUser(event) {
    event.preventDefault();
    let id = this.getAttribute("data-id");
    let url = "/api/users/" + id;
    sendAjaxRequest("delete", url, null, deleteUserHandler);
}

function deleteUserHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let id = JSON.parse(this.responseText);
    let closeModal = document.querySelector(
        '.delete_user_cancel[data-id="' + id + '"]'
    );
    closeModal.click();
    // update pagination
    let page = document.querySelector(".user_list").getAttribute("data-id");
    let url = "/api/users?page=" + page;
    sendAjaxRequest("get", url, null, pageUsersHandler);
}

function addAuctionCountdown() {
    let countdown = document.getElementById("countdown");
    if (countdown != null) {
        let date = countdown.getAttribute("data-id").replace(/-/g, "/");
        let countDownDate = new Date(date + " +0100").getTime();
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

    // If the count down is finished, write some text
    if (distance < 0) {
        setTimeout(() => {
            location.reload();
        }, 2000);
        countdown.innerHTML = "0s ";
    } else {
        // Change text color to red
        if (distance < 10000) {
            countdown.classList.add("text-danger");
        }

        // Display the result in the element with id="demo"
        if (days != 0)
            countdown.innerHTML =
                days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
        else if (hours != 0)
            countdown.innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
        else if (minutes != 0)
            countdown.innerHTML = minutes + "m " + seconds + "s ";
        else countdown.innerHTML = seconds + "s ";
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

function imageUploads() {
    let animalPicture = document.getElementById("animal_picture");
    if (animalPicture != null)
        animalPicture.addEventListener("change", function (event) {
            let animalPictureLabel = document.getElementById("animal_picture_label");
            let n = animalPicture.value.lastIndexOf("\\");
            let animalPictureName = animalPicture.value.substring(n + 1);

            animalPictureLabel.innerHTML = animalPictureName;
        });

    let userPicture = document.getElementById("profile_picture");
    if (userPicture != null)
        userPicture.addEventListener("change", function (event) {
            let userPictureLabel = document.getElementById("profile_picture_label");
            let n = userPicture.value.lastIndexOf("\\");
            let userPictureName = userPicture.value.substring(n + 1);

            userPictureLabel.innerHTML = userPictureName;
        });
}

function deleteProfileImage() {
    let delete_profile_image = document.querySelector(".delete_photo_confirm");
    if (delete_profile_image != null)
        delete_profile_image.addEventListener("click", deleteProfileImageClick);
}

function deleteProfileImageClick(event) {
    event.preventDefault();
    let id = this.getAttribute("data-id");
    let url = "/api/users/" + id + "/image";
    sendAjaxRequest("delete", url, null, deleteProfileImageHandler);
}

function deleteProfileImageHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let delete_profile_image = document.querySelector(".image_delete_button");
    let image = delete_profile_image.nextElementSibling;
    let close = document.querySelector(".delete_photo_cancel");
    delete_profile_image.remove();
    image.remove();
    close.click();
}

function hasUnreadNotifications(notifications) {
    let id = notifications.getAttribute("data-id");
    sendAjaxRequest("get", "/api/profiles/" + id + "/notif_count", null, hasUnreadNotificationsHandler);
}

function hasUnreadNotificationsHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let count = JSON.parse(this.responseText);
    let notifications = document.querySelector("#notification_bell");
    if (count > 0) {
        if (notifications.childElementCount == 1) {
            let img = document.createElement('img');
            img.setAttribute("src", "/assets/red_dot.png");
            img.setAttribute("height", "7");
            img.setAttribute("alt", "Unread Notifications");
            img.setAttribute("id", "red_dot");
            notifications.appendChild(img);
        }
    }
    else {
        if (notifications.childElementCount == 2)
            notifications.lastElementChild.remove();
    }
}

function getLastNotifications() {
    event.preventDefault();
    let id = this.getAttribute("data-id");
    sendAjaxRequest("get", "/api/profiles/" + id + "/notifications", null, getLastNotificationsHandler);
}

function getLastNotificationsHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
    let notifications_list = JSON.parse(this.responseText);

    let notifications = document.querySelector("#notifications");
    notifications.innerHTML = "";

    if (notifications_list.length == 0) {
        let p = document.createElement("p");
        p.setAttribute("class", "dropdown-item d-flex");
        p.innerHTML = "You have no new notifications";
        notifications.appendChild(p);
        return;
    }

    [].forEach.call(notifications_list, function (notification) {
        let a = document.createElement("a");
        a.setAttribute("class", "dropdown-item d-flex");
        a.setAttribute("data-id", notification.id);

        let span = document.createElement("span");
        if (notification.read)
            span.setAttribute("class", "text-secondary h3 mr-3 align-middle");
        else
            span.setAttribute("class", "text-danger h3 mr-3 align-middle");

        span.innerHTML = "&#8226;";

        let message = document.createElement("p");
        message.innerHTML = notification.message;

        if (notification.type == "bid_surpassed" || notification.type == "ended") {
            a.setAttribute("href", "/auctions/" + notification.id_auction);
            a.addEventListener('click', markRead);
        }
        else if (notification.type == "winner") {
            a.setAttribute("data-toggle", "modal");
            a.setAttribute("data-target", "#payment_shipping_modal");
            a.setAttribute("data-msg", notification.message);
            a.setAttribute("data-id_auction", notification.id_auction);
            a.setAttribute("href", "#");
            a.addEventListener("click", openMethodModal)
        }
        else if (notification.type == "rate") {
            a.setAttribute("data-toggle", "modal");
            a.setAttribute("data-target", "#rate_modal");
            a.setAttribute("data-msg", notification.message);
            a.setAttribute("data-id_auction", notification.id_auction);
            a.setAttribute("href", "#");
            a.addEventListener("click", openRateModal);
        }

        a.appendChild(span);
        a.appendChild(message);
        notifications.appendChild(a);
    });
}

function markRead() {
    let id = this.getAttribute("data-id");
    sendAjaxRequest("put", "/api/notifications/" + id + "/read", null, markReadHandler);
}

function markReadHandler() {
    if (this.status != 200) {
        console.log(this.status);
        console.log(this);
    }
}

function openMethodModal(event) {
    event.preventDefault();
    let title = document.querySelector("#payment_shipping_modal .modal-header h2");
    let msg = this.getAttribute("data-msg");
    let name = msg.substring(25, msg.length - 31);
    title.innerHTML = "Choose Methods For " + name + "'s Auction";

    let payMethodSelect = document.querySelector("#pay_method");
    let shipMethodSelect = document.querySelector("#ship_method");
    payMethodSelect.selectedIndex = "0";
    shipMethodSelect.selectedIndex = "0";

    let submit = document.querySelector("#method_button");
    submit.setAttribute("data-id_auction", this.getAttribute("data-id_auction"));
    submit.setAttribute("data-id", this.getAttribute("data-id"));
    submit.addEventListener("click", saveMethods);

    let close = document.querySelector("#method_modal_cancel");
    close.setAttribute("data-id", this.getAttribute("data-id"));
}

function openRateModal(event) {
    event.preventDefault();
    let title = document.querySelector("#rate_modal .modal-header h2");
    let msg = this.getAttribute("data-msg");
    let name = msg.substring(0, msg.length - 51);
    title.innerHTML = name + "'s Auction";

    let rating = document.querySelector("#rating_value");
    rating.value = "";

    let submit = document.querySelector("#rate_button");
    submit.setAttribute("data-id_auction", this.getAttribute("data-id_auction"));
    submit.setAttribute("data-id", this.getAttribute("data-id"));
    submit.addEventListener("click", saveRate);

    let close = document.querySelector("#rate_modal_cancel");
    close.setAttribute("data-id", this.getAttribute("data-id"));
}

addEventListeners();
