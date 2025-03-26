<!DOCTYPE html>
<html>
<head>
    <title>GRAFIK MAHASISWA</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container pt-5 m-auto ">
        <h1 style="font-family: 'Times New Roman', serif; text-align: center;">
            Membuat Grafik dengan PHP dan MySQL
        </h1>
        <div class="chart-container" style="position:relative; height:40vh; width:80vw; left: 30%; margin-top: 60px;">
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <div style="text-align: center;">
        <button id="downloadPDF" style="margin-top: 30px; padding: 6px; border-radius: 6px; cursor: pointer;">
            Download PDF
        </button>  
    </div>

    <?php
        include 'connect.php';
        $query = "SELECT jurusan, COUNT(*) AS jml_mahasiswa FROM mahasiswa GROUP BY jurusan;";
        $result = mysqli_query($con, $query);
        $jurusan = [];
        $jumlah = [];
        while ($data = mysqli_fetch_array($result)) {
            $jurusan[] = $data['jurusan'];
            $jumlah[] = $data['jml_mahasiswa'];
        }
    ?>

    <script>
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($jurusan); ?>,
                datasets: [{
                    label: 'Jumlah Mahasiswa',
                    data: <?php echo json_encode($jumlah); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 71, 1)',
                        'rgba(9, 31, 242, 0.8)',
                        'rgba(255, 128, 6, 0.8)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 71, 1)',
                        'rgba(9, 31, 242, 0.8)',
                        'rgba(255, 128, 6, 0.8)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        document.getElementById('downloadPDF').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF();
            const canvas = document.getElementById("myChart");
            const imgData = canvas.toDataURL("image/png"); 
            pdf.addImage(imgData, "PNG", 10, 10, 180, 100);
            pdf.save("chart.pdf"); 
        });
    </script>
</body>
</html>
