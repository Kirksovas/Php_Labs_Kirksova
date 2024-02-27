function appendToDisplay(value) {
  document.getElementById("display").innerText += value;
}

function clearDisplay() {
  document.getElementById("display").innerText = "";
}

function calculate() {
  const userInput = document.getElementById("display").innerText;

  fetch(`calc.php?expression=${encodeURIComponent(userInput)}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        updateDisplay("Ошибка: " + data.error);
      } else {
        updateDisplay(data.result);
      }
    })
    .catch((error) => {
      console.error("Ошибка:", error);
    });
}

function updateDisplay(value) {
  document.getElementById("display").innerText = value;
}
function backspace() {
  let currentExpression = document.getElementById("display").innerText;
  document.getElementById("display").innerText = currentExpression.slice(0, -1);
}
