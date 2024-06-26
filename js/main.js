(function ($) {
  "use strict";

  $(document).ready(function () {
    $(".select2_el").select2({});
  });

  $(document).ready(function () {
    function toggleNavbarMethod() {
      if ($(window).width() > 992) {
        $(".navbar .dropdown")
          .on("mouseover", function () {
            $(".dropdown-toggle", this).trigger("click");
          })
          .on("mouseout", function () {
            $(".dropdown-toggle", this).trigger("click").blur();
          });
      } else {
        $(".navbar .dropdown").off("mouseover").off("mouseout");
      }
    }
    toggleNavbarMethod();
    $(window).resize(toggleNavbarMethod);

    $(".chat-bot-icon").click(function (e) {
      $(this).children("img").toggleClass("hide");
      $(this).children("svg").toggleClass("animate");
      $(".chat-screen").toggleClass("show-chat");
    });
    $(".chat-mail button").click(function () {
      $(".chat-mail").addClass("hide");
      $(".chat-body").removeClass("hide");
      $(".chat-input").removeClass("hide");
      $(".chat-header-option").removeClass("hide");
    });
    $(".end-chat").click(function () {
      $(".chat-body").addClass("hide");
      $(".chat-input").addClass("hide");
      $(".chat-session-end").removeClass("hide");
      $(".chat-header-option").addClass("hide");
    });

    document.addEventListener("DOMContentLoaded", function () {
      const chatStart = document.querySelector(".chat-start");
      const currentDate = new Date();

      const day = currentDate.getDate();
      const month = currentDate.getMonth() + 1;
      const year = currentDate.getFullYear();
      const hour = currentDate.getHours();
      const minutes = currentDate.getMinutes();

      const formattedDate = `${day < 10 ? "0" + day : day}/${
        month < 10 ? "0" + month : month
      }/${year} ${hour}:${minutes < 10 ? "0" + minutes : minutes}`;

      chatStart.textContent = formattedDate;
      const chatInput = document.getElementById("chat-input");
      const sendMessageBtn = document.getElementById("send-message");
      const chatMessagesContainer = document.getElementById("chat-messages");

      sendMessageBtn.addEventListener("click", function () {
        const message = chatInput.value.trim();
        if (message !== "") {
          addMessage("me", message);
          chatInput.value = "";
          getResponseFromAPI(message)
            .then((response) => {
              addMessage("you", response);
            })
            .catch((error) => {
              console.error("Error al obtener respuesta de la API:", error);
              addMessage(
                "you",
                "Hubo un problema al obtener la respuesta. Por favor, intenta nuevamente."
              );
            });
        }
      });

      function addMessage(sender, message) {
        const messageBubble = document.createElement("div");
        messageBubble.className = `chat-bubble ${sender}`;
        messageBubble.textContent = message;
        chatMessagesContainer.appendChild(messageBubble);
      }

      async function getResponseFromAPI(userMessage) {
        const url =
          "https://jairodanielmt-gpt-3-5-api-key-academia.hf.space/send_message";
        const headers = new Headers();
        headers.set("Authorization", "Basic " + btoa("jairo:academia"));
        headers.set("Content-Type", "application/json");

        const body = JSON.stringify({
          user_name: "Jairo",
          text: userMessage,
        });

        const response = await fetch(url, {
          method: "POST",
          headers: headers,
          body: body,
        });

        if (!response.ok) {
          throw new Error("Network response was not ok " + response.statusText);
        }

        const data = await response.json();
        return data.response;
      }
    });
  });

  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      $(".back-to-top").fadeIn("slow");
    } else {
      $(".back-to-top").fadeOut("slow");
    }
  });
  $(".back-to-top").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo");
    return false;
  });

  // Date and time picker
  $(".date").datetimepicker({
    format: "L",
  });
  $(".time").datetimepicker({
    format: "LT",
  });

  // Testimonials carousel
  $(".testimonial-carousel").owlCarousel({
    autoplay: true,
    smartSpeed: 1500,
    margin: 30,
    dots: true,
    loop: true,
    center: true,
    responsive: {
      0: {
        items: 1,
      },
      576: {
        items: 1,
      },
      768: {
        items: 2,
      },
      992: {
        items: 3,
      },
    },
  });
})(jQuery);
