document.addEventListener("DOMContentLoaded", function () {
  const boton = document.getElementById("btnEnviar");
  const form = document.forms["abcPH"];

  boton.addEventListener("click", function () {
    mostrarConfirmacion("Estas seguro de realizar esta accion?", function () {
      form.submit();
    });
  });
});

function mostrarConfirmacion(mensaje, ok) {
  const cuadro = document.createElement("div");
  cuadro.style.position = "fixed";
  cuadro.style.top = 0;
  cuadro.style.left = 0;
  cuadro.style.width = "100%";
  cuadro.style.height = "100%";
  cuadro.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
  cuadro.style.display = "flex";
  cuadro.style.justifyContent = "center";
  cuadro.style.alignItems = "center";
  cuadro.style.zIndex = 1000;

  const popup = document.createElement("div");
  popup.style.background = "#fff";
  popup.style.padding = "20px";
  popup.style.borderRadius = "10px";
  popup.style.textAlign = "center";
  popup.style.boxShadow = "0 0 10px rgba(0,0,0,0.3)";

  const bt1 = document.createElement("button");
  const bt2 = document.createElement("button");
  const msj = document.createElement("p");
  msj.textContent = mensaje;
  msj.style.margin = "20px";

  bt1.id = "btnConfirmar";
  bt1.style.marginRight = "10px";
  bt1.padding = "10px 20px";
  bt1.textContent = "Aceptar";

  bt2.id = "btnCancelar";
  bt2.style.marginRight = "10px";
  bt2.padding = "10px 20px";
  bt2.textContent = "Cancelar";

  popup.appendChild(msj);
  popup.appendChild(bt1);
  popup.appendChild(bt2);
  cuadro.appendChild(popup);
  document.body.appendChild(cuadro);

  document
    .getElementById("btnConfirmar")
    .addEventListener("click", function () {
      document.body.removeChild(cuadro);
      ok();
    });

  document.getElementById("btnCancelar").addEventListener("click", function () {
    document.body.removeChild(cuadro);
  });
}
