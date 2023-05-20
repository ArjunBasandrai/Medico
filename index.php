<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="static/css/nav.css">
    <link rel="icon" type="image/x-icon" href="static/imgs/favicon.ico">
    <title>Medico: One step solution for your medical needs</title>
</head>
<body>
    <?php require_once "nav.php"; ?>
    <section>
        <div class="head flexbox">
            <h1>Get Your Prescriptions Sorted</h1>
            <form method="get" action="meds.php" class="get-med-form flexbox flexrow">
            <input type="text" class="get-med" name="med" placeholder="Enter medication name" required>
            <input type="submit" value="Search Nearby">
            </form>
        </div>
    </section>
    
    <section>
        <div class="site-save">
            <h2>Save at pharmacies near you</h2>
            <div class="pharm-row flexbox flexrow">
                <div class="site-pharm">
                    <h3>Saravan Pharmacy</h3>
                    <hr>
                    <ul>
                        <li>Albuterol</li>
                        <li>Aspirin</li>
                        <li>Ibuprofen</li>
                        <li>Amlodipine</li>
                    </ul>
                    <p class="pharm-p"><span style="color:green;">39%</span><span style="color:#666"> off with Medico</span></p>
                    <a href="#">Save here</a>
                </div>
                <div class="site-pharm">
                    <h3>Apollo Medicals</h3>
                    <hr>
                    <ul>
                        <li>Naproxen Sodium</li>
                        <li>Metoprolol</li>
                        <li>Albuterol</li>
                        <li>Paracetamol</li>
                    </ul>
                    <p class="pharm-p"><span style="color:green;">25%</span><span style="color:#666"> off with Medico</span></p>
                    <a href="#">Save here</a>
                </div>
                <div class="site-pharm">
                    <h3>Kayes Pharmacy</h3>  
                    <hr>
                    <ul>
                        <li>Aspirin</li>
                        <li>Albuterol</li>
                        <li>Ibuprofen</li>
                        <li>Metoprolol</li>
                    </ul>
                    <p class="pharm-p"><span style="color:green;">54%</span><span style="color:#666"> off with Medico</span></p>
                    <a href="#">Save here</a>
                </div>
                <div class="site-pharm">
                    <h3>Arun Pharma</h3>
                    <hr>
                    <ul>
                        <li>Simvastatin</li>
                        <li>Ibuprofen</li>
                        <li>Naproxen Sodium</li>
                        <li>Metformin</li>
                    </ul>
                    <p class="pharm-p"><span style="color:green;">15%</span><span style="color:#666"> off with Medico</span></p>
                    <a href="#">Save here</a>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="common">
            <h2>Common Health Conditions</h2>
            <div class="com-row flexbox flexrow">
                <div class="coms">
                    <img src="https://www.grxstatic.com/d4fuqqd5l3dbz/static/img/photo-condition-allergies.jpg" alt="" class="com-img">
                    <p>Allergies</p>
                    <hr>
                    <p class="common-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia eius aliquid nulla voluptatem, exercitationem porro quasi nisi quae a possimus.</p>
                    <a href="#">Get Help</a>
                </div>
                <div class="coms">
                    <img src="https://www.grxstatic.com/d4fuqqd5l3dbz/static/img/photo-condition-acne.jpg" alt="" class="com-img">
                    <p>Acne</p>
                    <hr>
                    <p class="common-desc">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Deserunt cumque dolore nam molestias, ducimus harum sed explicabo ipsa commodi soluta?</p>
                    <a href="#">Get Help</a>
                </div>
                <div class="coms">
                    <img src="https://www.grxstatic.com/d4fuqqd5l3dbz/static/img/photo-condition-flu.jpg" alt="" class="com-img">
                    <p>Flu</p>
                    <hr>
                    <p class="common-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum aspernatur odio accusantium sequi veniam illum explicabo ipsum voluptatum incidunt saepe.</p>
                    <a href="#">Get Help</a>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="head flexbox">
            <h1>Get Medical Help</h1>
            <form method="get" action="emergency.php" class="get-med-form flexbox flexrow">
            <input type="text" class="get-med" name="med" placeholder="Enter your pincode (Eg. 632014)" required>
            <input type="submit" value="Search Hospitals">
            </form>
        </div>
    </section>
    <?php require_once "footer.php"; ?>
</body>
</html>