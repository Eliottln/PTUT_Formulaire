import 'https://code.jquery.com/jquery-3.6.0.js';
import 'https://code.jquery.com/ui/1.13.0/jquery-ui.js';

$(function () {
    // run the currently selected effect
    function runEffect() {
        // get effect type from
        var selectedEffect = $("#effectTypes").val();

        // Most effect types need no options passed by default
        var options = {};
        // some effects have required parameters
        if (selectedEffect === "scale") {
            options = { percent: 50 };
        } else if (selectedEffect === "size") {
            options = { to: { width: 200, height: 60 } };
        }

        // Run the effect
        $("#effect").hide(selectedEffect, options, 1000, callback);
    };

    // Callback function to bring a hidden box back
    function callback() {
        setTimeout(function () {
            $("#effect").removeAttr("style").hide().fadeIn();
        }, 1000);
    };

    // Set effect from select menu value
    $("#button").on("click", function () {
        runEffect();
    });
});

document.getElementByID('effect').style = 'width: 240px; height: 170px; padding: 0.4em; position: relative;';

class Notification {

    constructor(message, duration = 3) {
        this.message = message;
        this.duration = duration;

        this.show()
    }

    show() {
        let div = document.createElement('div');
        div.id = 'effect';
        let message = document.createElement('p');

        message.innerHTML = this.message;

        div.appendChild(message);

        document.documentElement.appendChild(div);
        console.log(message);
        this.css(div, message)
    }

}

//TEST AND FAILED