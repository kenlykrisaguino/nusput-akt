document.addEventListener("keydown", function (event) {
    let inputs = Array.from(document.querySelectorAll("input"));
    let index = inputs.indexOf(document.activeElement);
    let cols = 3; // Jumlah kolom

    if (index !== -1) {
        switch (event.key) {
            case "ArrowRight": // Pindah ke kanan
                if ((index + 1) % cols !== 0) inputs[index + 1].focus();
                break;
            case "ArrowLeft": // Pindah ke kiri
                if (index % cols !== 0) inputs[index - 1].focus();
                break;
            case "ArrowDown": // Pindah ke bawah
                let nextRow = index + cols;
                if (nextRow < inputs.length) inputs[nextRow].focus();
                break;
            case "ArrowUp": // Pindah ke atas
                let prevRow = index - cols;
                if (prevRow >= 0) inputs[prevRow].focus();
                break;
        }
    }
});
