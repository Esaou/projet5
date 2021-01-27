<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/marqueur.png">
    <meta property="og:image" content="images/marqueur.png" />
    <title>Professionnels de santé</title>

</head>

<body>
    <?php require 'headerAndFooter/header.php' ?>
    <section id="sectionPro">
        <div class="menuSante" id="ancre">
            <a href="pageMed.php#ancre" id="btnMed">Médecins généralistes</a>
            <a href="pageInf.php#ancre" id="btnInf">Infirmières</a>
            <a href="pageOrtho.php#ancre" id="btnOrtho">Orthophonistes</a>
            <a href="pagePsycho.php#ancre" id="btnPsycho">Psychologues</a>
            <a href="pageOsteo.php#ancre" id="btnOsteo">Ostéopathe</a>
            <a href="pageHypno.php#ancre" id="btnHypno">Hypnothérapeute</a>
            <a href="pageArt.php#ancre" class="margePro" id="btnArt">Art-Danse-Thérapeute</a>
            <a href="pageDiet.php#ancre" class="btnDiet">Diététicien</a>
            <a href="pageNat.php#ancre">Naturopathe</a>
            <a href="pageCoach.php#ancre">Coach énergétique</a>
        </div>
        <div id="blocPro">
            <article class="psy">
                <img src="images/camilleA.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Camille ARNAUD</span>
                    <span class="statutPro">Psychologue clinicienne<br/>(en charge de l'autisme)</span>
                    <span class="emplacement">1er étage</span>
                    <span class="surRdv">Sur rendez-vous</span>
                    <span class="tel">Téléphone : 07 66 26 15 01</span>
                </div>
            </article>
            <article class="psy">
                <img src="images/id.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Lionel BAUCHOT</span>
                    <span class="statutPro">Psychologue</span>
                    <span class="emplacement">1er étage</span>
                    <span class="surRdv">Sur rendez-vous</span>
                    <span class="tel">Téléphone : 06 22 61 84 69</span>
                    <a class="redirection" href="https://lionelbauchot-psychologue.com/">Site Web</a>
                </div>
            </article>
            <article class="ortho">
                <img src="images/id.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Lucille BOURGET</span>
                    <span class="statutPro">Orthophoniste</span>
                    <span class="emplacement">1er étage</span>
                    <span class="surRdv">Sur rendez-vous</span>
                    <span class="tel">Téléphone : 09 72 63 01 33</span>
                </div>
            </article>
            <article class="inf">
                <img src="images/id.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Narimène DELLOUM</span>
                    <span class="statutPro">Infirmière</span>
                    <span class="emplacement">Rez-de-chaussée</span>
                    <span class="surRdv">Sur rendez-vous</span>
                    <span class="tel">Téléphone : 07 85 56 55 03</span>
                </div>
            </article>
            <article class="ortho">
                <img src="images/id.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Raissa EVRAT-TOUPANCE</span>
                    <span class="statutPro">Orthophoniste</span>
                    <span class="emplacement">1er étage</span>
                    <span class="surRdv">Sur rendez-vous</span>
                    <span class="tel">Téléphone : 06 95 10 58 58</span>
                </div>
            </article>
            <article class="ortho">
                <img src="images/nadineF.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Nadine Fourier</span>
                    <span class="statutPro">Coach énergétique</span>
                    <span class="emplacement">1er étage</span>
                    <a class="redirection" href="https://www.entrecorpsetame.com/">Sur rendez-vous (en ligne)</a>   
                    <span class="tel">Téléphone : 06 71 13 79 98</span>
                    <a class="redirection" href="https://www.entrecorpsetame.com/">Site Web</a>
                </div>
            </article>
            <article class="inf">
                <img src="images/id.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Aurélie KODAT</span>
                    <span class="statutPro">Infirmière</span>
                    <span class="emplacement">Rez-de-chaussée</span>
                    <span class="surRdv">Sur rendez-vous</span>
                    <span class="tel">Téléphone : 07 85 56 55 03</span>
                </div>
            </article>
            <article class="ortho">
                <img src="images/mLacombe.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Marjolaine LACOMBE</span>
                    <span class="statutPro">Naturopathe-Reflexologue</span>
                    <span class="emplacement">1er étage</span>
                    <span class="surRdv">Sur rendez-vous</span>
                    <span class="tel">Téléphone : 06 72 65 59 10</span>
                    <a class="redirection" href="https://marjolaine-naturopathie.fr/contact/">Site Web</a>
                </div>
            </article>
            <article  class="ortho">
                <img src="images/id.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Leslie MARSAL</span>
                    <span class="statutPro">Orthophoniste</span>
                    <span class="emplacement">1er étage</span>
                    <span class="surRdv">Sur rendez-vous</span>
                    <span class="tel">Téléphone : 09 81 25 22 46</span>
                </div>
            </article>
            <article class="med">
                <img src="images/baptisteM.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Baptiste MEUNIER</span>
                    <span class="statutPro">Médecin généraliste<br/>Conventionné secteur 1
                    </span>
                    <span class="emplacement">Rez-de-chaussée</span>
                    <a class="redirection" href="https://www.ubiclic.com/medecine-generale/st-martin-d-heres/dr-meunier-baptiste">Sur rendez-vous (en ligne)</a>   
                    <span class="tel">Téléphone : 04 76 62 27 95</span>
                </div>
            </article>
            <article class="med">
                <img src="images/id.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Juliette PERCHET</span>
                    <span class="statutPro">Médecin généraliste<br/>Conventionné secteur 1<p style="margin-bottom:0px;color:rgb(100,100,100);">Assistante Dr Meunier <br/>DIU Gynécologie</p>
                    </span>
                    <span class="emplacement">Rez-de-chaussée</span>
                    <a class="redirection" href="https://www.ubiclic.com/autre/st-martin-d-heres/dr-juliette-perchet">Sur rendez-vous (en ligne)</a>   
                    <span class="tel">Téléphone : 04 76 62 27 95</span>
                </div>
            </article>
            <article class="osteo">
                <img src="images/marianoR.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Mariano ROSALES</span>
                    <span class="statutPro">Ostéopathe D.O<br/>Ostéopathe du sport</span>
                    <span class="emplacement">1er étage</span>
                    <span class="surRdv">Sur rendez-vous</span>
                    <span class="tel">Téléphone : 07 63 20 72 23</span>
                    <a class="redirection" href="https://www.facebook.com/marianorosales.osteo/?ref=aymt_homepage_panel&eid=ARCeoEgr59vfwDcBF-pWlkBNteOctiKwJRl3Y9vzNyERmywoOhwtAS8ulBr7UWTc7UKv8pdz1zbRLhLv">Site Web</a>
                </div>
            </article>
            <article class="med">
                <img src="images/paulS.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Paul SAOU</span>
                    <span class="statutPro">Médecin généraliste<br/>Conventionné secteur 1</span>
                    <span class="emplacement">Rez-de-chaussée</span>
                    <a class="redirection" href="https://www.ubiclic.com/medecine-generale/st-martin-d-heres/dr-saou-paul">Sur rendez-vous (en ligne)</a>
                    <span class="tel">Téléphone : 04 76 62 27 95</span>
                </div>
            </article>
            <article class="med">
                <img src="images/clementS.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Clément SÉNÉCHAL</span>
                    <span class="statutPro">Médecin généraliste<br/>Conventionné secteur 1
                    </span>
                    <span class="emplacement">Rez-de-chaussée</span>
                    <a class="redirection" href="https://www.ubiclic.com/autre/st-martin-d-heres/dr-clement-senechal">Sur rendez-vous (en ligne)</a>   
                    <span class="tel">Téléphone : 04 76 62 27 95</span>
                </div>
            </article>
            <article class="art">
                <img src="images/marieT.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Marie-Lucienne THEODOSE</span>
                    <span class="statutPro">Art-Danse Thérapeute</span>
                    <span class="emplacement">1er étage</span>
                    <a class="redirection" href="https://artvieup.wixsite.com/website/consultation-reservation">Sur rendez-vous (en ligne)</a>
                    <span class="tel">Téléphone : 04 58 00 32 92</span>
                    <a class="redirection" href="https://artvieup.wixsite.com/website">Site Web</a>
                </div>
            </article>
            <article class="hyp">
                <img src="images/lenaicU.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Lénaïc URREA</span>
                    <span class="statutPro">Hypnose Ericksonienne</span>
                    <span class="emplacement">1er étage</span>
                    <span class="surRdv">Sur rendez-vous</span>
                    <span class="tel">Téléphone : 06 43 94 05 59</span>
                    <a class="redirection" href="https://www.hypnovant.fr/">Site Web</a>
                </div>
            </article>
            <article class="ortho">
                <img src="images/id.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Blandine VEDRENNE</span>
                    <span class="statutPro">Orthophoniste</span>
                    <span class="emplacement">1er étage</span>
                    <span class="surRdv">Sur rendez-vous</span>
                    <span class="tel">Téléphone : 06 49 30 08 21</span>
                </div>
            </article>
            <article class="ortho">
                <img src="images/id.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Maryse VIAL</span>
                    <span class="statutPro">Orthophoniste</span>
                    <span class="emplacement">1er étage</span>
                    <span class="surRdv">Sur rendez-vous</span>
                    <span class="tel">Téléphone : 09 72 62 91 05</span>
                </div>
            </article>
            <article class="psy">
                <img src="images/deryaY.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Derya YÜCELIR</span>
                    <span class="statutPro">Neuropsychologue</span>
                    <span class="emplacement">1er étage</span>
                    <span class="surRdv">Sur rendez-vous</span>
                    <span class="tel">Téléphone : 07 67 87 52 04</span>
                </div>
            </article>
            <article class="med">
                <img src="images/id.jpg" alt="photoID" class="photoId">
                <div class="infoPro">
                    <span class="nomPro">Marine ZAVARONI</span>
                    <span class="statutPro">Médecin généraliste<br/>Conventionné secteur 1</span>
                    <span class="emplacement">Rez-de-chaussée</span>
                    <a class="redirection" href="https://www.ubiclic.com/autre/st-martin-d-heres/dr-marine-zavaroni">Sur rendez-vous (en ligne)</a>
                    <span class="tel">Téléphone : 04 76 62 27 95</span>
                </div>
            </article>
        </div>
    </section>
    <?php require 'headerAndFooter/footer.php' ?>
    <div id="boutonScroll">
        <a href="#top"><img src="images/fleche.png" alt="btnPage" class="fleche"/></a>
    </div>
</body>

</html>