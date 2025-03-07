(function () {
  "use strict";
  var items = [];
  var winnerStatus = false;
  const doors = document.querySelectorAll(".door");

  

  document.querySelector("#slot-machine-video-btn").addEventListener("click", function() {
    // reproducir video play 
    const button = this;
    const userId = button.getAttribute("data-user-id");
    const purchaseNumber = button.getAttribute("data-purchase-number");
    const name = button.getAttribute("data-name");
    const lastName = button.getAttribute("data-last-name");
    const email = button.getAttribute("data-email");
    const telephone = button.getAttribute("data-telephone");
    const bank = button.getAttribute("data-bank");
    spin(userId, purchaseNumber, name, lastName, email, telephone, bank);
  });


  async function spin(userId, purchaseNumber, name, lastName, email, telephone, bank) {
    let res = await getAward(userId, purchaseNumber, name, lastName, email, telephone, bank);
    let data = await res.json();
    winnerStatus = data.winnerStatus;
    if(winnerStatus){
      document.getElementById('mp3-ganador').play();
    }else{
      document.getElementById('mp3-perdedor').play();
    }
    items = (data.slots);
    backgroundMachine(winnerStatus)
    init(false, 1, 4);
    let status = false;
    for (const door of doors) {
      const boxes = door.querySelector(".boxes");
      //const duration = parseInt(boxes.style.transitionDuration);
      boxes.style.transform = "translateY(0)";
      
      await new Promise((resolve) => setTimeout(resolve, 800));
     
    }
    if(winnerStatus){
      setTimeout(showConfetti, 3400);
      setTimeout(() => {
        showModal("background-modal-winner");
        showLoadDataWinner('winner-name', `!${data.winnerName}!`);
        showLoadDataWinner('winner-data', data.winnerData);
        showLoadDataWinner('winner-email', data.winnerEmail);
      },6000);
    }
    
  }

  function backgroundMachine(winner){
    if(winner){
      document.getElementById('slot-machine-video-winner').style.display = 'block';
      document.getElementById('slot-machine-video-loser').style.display = 'none';
    }
    let video = document.getElementById(`slot-machine-video-${winner ? 'winner' : 'loser'}`);

    video.play();
  } 
  function init(firstInit = true, groups = 1, duration = 1) {
    for (const door of doors) {
      // validar si ya se ha girado 
      if (firstInit) {
        door.dataset.spinned = "0";
      } else if (door.dataset.spinned === "1") {
        return;
      }

      const boxes = door.querySelector(".boxes");
      const boxesClone = boxes.cloneNode(false);

      const pool = ["./resources/img/question.png"];
      if (!firstInit) {
        const arr = [];
        for (let n = 0; n < (groups > 0 ? groups : 1); n++) {
          arr.push(...items);
        }
        //pool.push(...shuffle(arr));
        pool.push(...arr);
        boxesClone.addEventListener(
          "transitionstart",
          function () {
            door.dataset.spinned = "1";
            this.querySelectorAll(".box img").forEach((img) => {
              img.style.filter = "blur(0px)";
            });
          },
          { once: true }
        );

        boxesClone.addEventListener(
          "transitionend",
          function () {
            this.querySelectorAll(".box img").forEach((img, index) => {
              img.style.filter = "blur(0)";
              if (index > 0) this.removeChild(img.parentElement);
            });
          },
          { once: true }
        );
      }

      for (let i = pool.length - 1; i >= 0; i--) {
        const box = document.createElement("div");
        box.classList.add("box");
        box.style.width = door.clientWidth + "px";
        box.style.height = door.clientHeight + "px";
        const img = document.createElement("img");
        img.src = pool[i];
        img.style.width = "100%";
        img.style.height = "100%";
        box.appendChild(img);
        boxesClone.appendChild(box);
      }
      boxesClone.style.transitionDuration = `${duration > 0 ? duration : 1}s`;
      boxesClone.style.transform = `translateY(-${door.clientHeight * (pool.length - 1)
        }px)`;
      door.replaceChild(boxesClone, boxes);
    }
  }

  /* function shuffle([...arr]) {
     let m = arr.length;
     while (m) {
       const i = Math.floor(Math.random() * m--);
       [arr[m], arr[i]] = [arr[i], arr[m]];
     }
     return arr;
   }*/

  init();
})();

async function getAward(userId, purchaseNumber, name, lastName, email, telephone, bank) {
  return await fetch("https://promocionesenlinea.store/sorteo/", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      "userId": userId,
      "purchaseNumber": purchaseNumber,
      "name": name,
      "lastName": lastName,
      "email": email,
      "telephone": telephone,
      "bank": bank
    }),
  });
}

function showConfetti(){
  const end = Date.now() + 15 * 1000;

  // go Buckeyes!
  const colors = ["#bb0000", "#ffffff"];
  
  (function frame() {
    confetti({
      particleCount: 2,
      startVelocity: 30,
      spread: 360,
      origin: { x: Math.random(), y: 0 },
      colors: colors,
    });

    confetti({
      particleCount: 2,
      startVelocity: 30,
      spread: 30,
      origin: { x: Math.random(), y: 0 },
      colors: colors,
    });
    if (Date.now() < end) {
      requestAnimationFrame(frame);
    }
  })();
}


function closeModal(id) {
  document.getElementById(id).style.display = "none";
}

function showModal(id) {
  document.getElementById(id).style.display = "flex";
}

function showLoadDataWinner(id, data){
  document.getElementById(id).innerHTML = data;
}

