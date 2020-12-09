-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 09 déc. 2020 à 16:32
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `etoile`
--

-- --------------------------------------------------------

--
-- Structure de la table `activites`
--

DROP TABLE IF EXISTS `activites`;
CREATE TABLE IF NOT EXISTS `activites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activite` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `titre` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `activites`
--

INSERT INTO `activites` (`id`, `activite`, `description`, `titre`, `photo`) VALUES
(3, 'Pyschologie', '<p>La psychologie, est une discipline scientifique qui s\'int&eacute;resse &agrave; l\'&eacute;tude du corpus des connaissances sur les faits psychiques, des comportements et des processus mentaux. La psychologie est la connaissance empirique ou intuitive des sentiments, des id&eacute;es, des comportements d\'une personne et des mani&egrave;res de penser, de sentir, d\'agir qui caract&eacute;risent un individu ou un groupe. Il est commun de d&eacute;finir aussi la psychologie comme l\'&eacute;tude scientifique des comportements.</p>\r\n<p>La psychologie est une discipline qui appartient &agrave; la cat&eacute;gorie des sciences humaines. Divis&eacute;e en de nombreuses branches d&rsquo;&eacute;tude dont les th&eacute;ories et les m&eacute;thodes de recherche varient grandement, la psychologie a des applications nombreuses.</p>', 'Psychologues', 'Pyschologie.jpg'),
(4, 'Orthophonie', '<p>L&rsquo;orthophonie est une discipline th&eacute;rapeutique qui vise &agrave; soigner les troubles du langage &eacute;crit et oral. Dans cette fiche, vous d&eacute;couvrirez cette discipline plus en d&eacute;tails, en quoi consiste un bilan orthophonique, quels sont les troubles que l&rsquo;orthophonie permet de soigner, comment se d&eacute;roule une s&eacute;ance, comment devenir orthophoniste et enfin, quelles sont les contre-indications ?</p>\r\n<p>Provenant des mots \"ortho\" qui signifie \"droit\" et phonie\" qui veut dire \"voix\", l&rsquo;orthophonie est une discipline param&eacute;dicale parfois appel&eacute;e logop&eacute;die qui permet la prise en charge des troubles du langage &eacute;crit et oral et plus largement des troubles de la communication. L\'orthophoniste s\'occupe &eacute;galement des troubles de l\'audition, de la voix et de la d&eacute;glutition. Il d&eacute;tecte, &eacute;value et propose une prise en charge de ces troubles.</p>\r\n<p>L\'objectif global de l\'orthophonie est que la personne prise en charge communique mieux, &agrave; l\'&eacute;crit ou &agrave; l\'oral. Cela peut passer dans certains cas non pas par une r&eacute;&eacute;ducation mais par des strat&eacute;gies palliatives comme l\'utilisation de l\'informatique en cas de paralysies par exemple.</p>', 'Orthophonistes', 'Orthophonie.jpg'),
(5, 'MÃ©decine gÃ©nÃ©rale', '<p>La m&eacute;decine g&eacute;n&eacute;rale, ou m&eacute;decine familiale, est une sp&eacute;cialit&eacute; m&eacute;dicale prenant en charge le suivi durable, le bien-&ecirc;tre et les soins de sant&eacute; g&eacute;n&eacute;raux primaires d\'une communaut&eacute;, sans se limiter &agrave; des groupes de maladies relevant d\'un organe, d\'un &acirc;ge, ou d\'un sexe particulier.</p>\r\n<p>Le m&eacute;decin g&eacute;n&eacute;raliste, aussi appel&eacute; m&eacute;decin omnipraticien ou m&eacute;decin de famille, est donc souvent consult&eacute; pour diagnostiquer les sympt&ocirc;mes avant de traiter la maladie ou de r&eacute;f&eacute;rer le patient &agrave; un autre m&eacute;decin sp&eacute;cialiste.</p>\r\n<p>Dans la plupart des cas, le m&eacute;decin traitant d\'une personne est un m&eacute;decin g&eacute;n&eacute;raliste. Un exemple d\'une exception serait un jeune qui a un p&eacute;diatre (m&eacute;decin sp&eacute;cialiste) pour m&eacute;decin traitant. Les m&eacute;decins omnipraticiens, cependant, ont aussi toutes les comp&eacute;tences n&eacute;cessaires pour les traiter de fa&ccedil;on efficace.</p>', 'MÃ©decins gÃ©nÃ©ralistes', 'MÃ©decine gÃ©nÃ©rale.jpg'),
(7, 'Infirmerie', '<p>Une infirmerie est un endroit o&ugrave; sont dispens&eacute;s des soins pratiqu&eacute;s par des infirmiers ou des infirmi&egrave;res.</p>\r\n<p>Ce lieu est, en g&eacute;n&eacute;ral, situ&eacute; dans un b&acirc;timent et &agrave; proximit&eacute; d\'activit&eacute; r&eacute;unissant un personnel suffisamment nombreux.</p>\r\n<p>Il existe toutefois des infirmeries mobiles par nature (bateau) ou temporaires. Ces derni&egrave;res sont install&eacute;es lors de grands rassemblements de personnes (manifestations, spectacles, sports) ainsi que sur les lieux d\'un sinistre ou d\'une catastrophe. Elles sont souvent mises en place par la Croix-Rouge ou les services de s&eacute;curit&eacute; civile.</p>', 'InfirmiÃ¨res', 'Infirmerie.jpg'),
(8, 'Osteopathie', '<p>L&rsquo;ost&eacute;opathie est bas&eacute;e sur des manipulations osseuses ou musculaires.</p>\r\n<p>L&rsquo;ost&eacute;opathie est une th&eacute;rapeutique manuelle fond&eacute;e sur des manipulations osseuses ou musculaires.</p>\r\n<p>Cette technique est apparue au XIXe si&egrave;cle aux Etats- Unis. Son fondateur, le Dr Andrew Taylor Still, partait du principe que le bien-&ecirc;tre du corps humain est li&eacute; au bon fonctionnement de son appareil locomoteur (squelette, articulations, muscles, tendons, nerfs).</p>\r\n<p>En effet, toutes les parties du corps &eacute;tant reli&eacute;es entre elles par l\'interm&eacute;diaire des tissus organiques qui le composent, le corps constitue une unit&eacute; fonctionnelle indissociable. D&egrave;s qu\'une structure du corps pr&eacute;sente une perturbation dans son fonctionnement, cela retentit sur le fonctionnement de structures situ&eacute;es &agrave; distance par le biais de ces corr&eacute;lations tissulaires.</p>\r\n<p>L\'ost&eacute;opathie est une pratique exclusivement manuelle qui l&egrave;ve en particulier les blocages articulaires du corps pour lui permettre de mieux fonctionner.</p>\r\n<p>Elle agit &agrave; distance &agrave; partir du syst&egrave;me musculo-squelettique sur les principaux organes du corps humain en utilisant des techniques de pression, d&rsquo;&eacute;longation ou de torsion.</p>\r\n<p>Les meilleurs r&eacute;sultats sont obtenus sur les probl&egrave;mes dits &laquo; fonctionnels &raquo;, c&rsquo;est-&agrave;-dire les douleurs dont on ne trouve pas la cause, mais qui g&ecirc;nent parfois depuis tr&egrave;s longtemps la vie quotidienne : douleurs vert&eacute;brales, costales et articulaires, tendinites, douleurs et traumatismes musculaires, maux de t&ecirc;te, migraines et vertiges&hellip;</p>', 'Osteopathes', 'Osteopathie.jpg'),
(9, 'Hypnose', '<p>En franÃ§ais, le terme hypnose dÃ©signe Ã  la fois des Ã©tats modifiÃ©s de conscience, les pratiques thÃ©rapeutiques utilisÃ©es pendant cet Ã©tat, et les techniques permettant de crÃ©er cet Ã©tat (appelÃ©es techniques dâ€™inductions).</p>\r\n<p>Lorsquâ€™un individu est dans un Ã©tat dâ€™hypnose, ses perceptions sont modifiÃ©es par rapport Ã  son Ã©tat ordinaire. Les caractÃ©ristiques de ces Ã©tats sont variÃ©s, notamment : perte des repÃ¨res spatio-temporels, hallucinations, analgÃ©sies, anesthÃ©sies, etc. L\'expÃ©rience hypnotique d\'une personne dÃ©pend de sa personnalitÃ©, du contexte, de la mÃ©thode employÃ©e, des suggestions qui lui sont faites, de la profondeur de l\'induction hypnotique, et d\'autres paramÃ¨tres.</p>\r\n<p>Une personne peut Ã©galement dÃ©velopper une hypnose spontanÃ©e ou provoquer soi-mÃªme sa propre hypnose. On parle alors dâ€™autohypnose.</p>', 'HypnothÃ©rapeutes', 'Hypnose.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `objet` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `nom`, `email`, `objet`, `message`, `date`) VALUES
(45, 'Eric', 'eric.test@gmail.com', 'Test message', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2020-11-24 17:56:44');

-- --------------------------------------------------------

--
-- Structure de la table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `contenu` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pages`
--

INSERT INTO `pages` (`id`, `nom`, `contenu`) VALUES
(1, 'accueil', '<p>Les v&eacute;los, trottinettes et rollers sont interdits &agrave; l\'int&eacute;rieur de l\'espace sant&eacute;.</p>\r\n<p>Pour assurer la continuit&eacute; des soins dans les meilleures conditions possibles, nous avons mis en place des mesures de protection barri&eacute;res :</p>\r\n<ul>\r\n<li>Impossibilit&eacute; de rester en salle d\'attente pour les accompagnants pendant la dur&eacute;e des consultations ainsi que dans les zones de circulation (couloirs, escaliers, halls d\'entr&eacute;e).</li>\r\n<li>Une d&eacute;sinfection des locaux est effectu&eacute;e r&eacute;guli&eacute;rement.</li>\r\n<li>Merci de vous pr&eacute;senter avec un \"masque barri&egrave;re\" sauf pour les enfants de moins de 6 ans.</li>\r\n<li>Il est demand&eacute; au patient d\'arriver &agrave; l\'heure pr&eacute;cise de rendez-vous.</li>\r\n</ul>'),
(2, 'presentation', '<p>Centre, un terme qui vient du latin centrum, est un concept polys&eacute;mique. Il peut s\'agir du point int&eacute;rieur &agrave; &eacute;gale distance des limites d\'une surface, du lieu ou convergent des actions coordonn&eacute;es, des zones &agrave; forte activit&eacute; commerciale ou de l\'endroit ou les personnes se rencontrent &agrave; une fin donn&eacute;e.</p>\r\n<p>Sant&eacute;, d\'autre part, est l\'&eacute;tat de complet bien-&ecirc;tre physique, mental et social. La notion transcende l\'absence de maladies et se ref&egrave;re au niveau de l\'efficacit&eacute; fonctionnelle et m&eacute;tabolique d\'un organisme. Un centre de sant&eacute; (dit aussi cabinet m&eacute;dical) est un batiment destin&eacute; aux soins de sant&eacute; de la population. Le type de soins m&eacute;dicaux et la qualification du personnel peut varier selon le centre et la r&eacute;gion.</p>\r\n<p>En r&egrave;gle g&eacute;n&eacute;rale, le centre de sant&eacute; compte sur le travail des praticiens, des p&eacute;diatres, des infirmiers et du personnel administratif. Il est &eacute;galement possible que d\'autres professionnels agissent, notamment des travailleurs sociaux et des psychologues, ce qui permet d\'augmenter le nombre de services. Le centre de sant&eacute; est habituellement un endroit destin&eacute; aux soins primaires. Si le patient a besoin de soins plus complexes, sp&eacute;cifiques ou approfondis, il est renvoy&eacute; &agrave; un autre endroit, comme un hopital.</p>\r\n<p>Cela signifie que dans certains pays, les centres de sant&eacute; sont connus sous la d&eacute;signation de centres de soins de sant&eacute; primaires. Les professionnels de ces centres, par cons&eacute;quent, se consacrent aux soins de sant&eacute; de base. Ce genre d\'&eacute;tablissements est tr&egrave;s fr&eacute;quent dans les zones recul&eacute;es ou &agrave; faibles ressources dans la mesure ou ils constituent un confinement sanitaire et social imm&eacute;diat.</p>'),
(3, 'projetSoin', '<p>Prise en charge du patient innovante pour les raisons suivantes :</p>\r\n<p>Il est une r&eacute;ponse &agrave; la demande d\'accompagnement exprim&eacute; par un patient atteint d\'une affection chronique et/ou son m&eacute;decin traitant mais avec deux objectifs :</p>\r\n<ul>\r\n<li>essayer de rem&eacute;dier &agrave; un &eacute;cueil de la prise en charge en &eacute;ducation th&eacute;rapeutique &agrave; savoir aider le patient &agrave; exprimer ses r&eacute;els besoins au cours du bilan &eacute;ducatif partag&eacute; que pratiquent de nombreux professionnels de sant&eacute; l\'intervention d\'un coach &agrave; cet &eacute;tape va dans ce sens.</li>\r\n<li>mettre en place une r&eacute;elle collaboration entre le patient et l\'&eacute;quipe d\'intervenants au cours de son parcours, afin de favoriser son autonomie et l\'amener &agrave; une meilleure prise en charge de sa maladie alors qu\'actuellement les malades subissent souvent leur maladie n\'osant affirmer leurs r&eacute;els besoins.</li>\r\n<li>il permet de faire travailler ensemble une &eacute;quipe pluridisciplinaire centr&eacute;e surl\'autonomisation du malade vis &agrave; vis de sa maladie et des professionnels intervenants dans sa prise en charge. Pour la premi&egrave;re fois il associe des th&eacute;rapeutes ou intervenants ayant une approche des besoins humains diff&eacute;rents (psychologiques, physiques, m&eacute;dicaux, &eacute;nerg&eacute;tiques, rapprochement avec la nature, alimentaires, expression corporelle, r&eacute;flexologie, plantes ...)</li>\r\n</ul>\r\n<p>Les intervenants sont situ&eacute;s en un seul lieu et vont apprendre &agrave; travailler ensemble.</p>\r\n<ul>\r\n<li>Il est pr&eacute;vu de mettre en place des soins &agrave; distance pour parer &agrave; la crise sanitaire et r&eacute;pondre aux urgences d\'accompagnement et il est &eacute;galement pr&eacute;vu dans un deuxi&egrave;me temps de d&eacute;velopper un site permettant au patient d\'acc&eacute;der au parcours &agrave; distance. On peut envisager la cr&eacute;ation de questionnaires accessibles &agrave; distance permettant d\'aider le patient &agrave; d&eacute;terminer ses besoins.</li>\r\n</ul>\r\n<p>Pour favoriser l\'autonomie du patient nous ferons appel &agrave; l\'intervention d\'une conseill&egrave;re en &eacute;conomie sociale et familiale avec deux objectifs :</p>\r\n<ul>\r\n<li>aider le patient &agrave; r&eacute;pondre &agrave; ses besoins de sant&eacute; dans l\'&eacute;laboration de son budget</li>\r\n<li>&eacute;tudier une participation financi&egrave;re du patient en fonction de son quotient familial pour participer au parcours propos&eacute;.</li>\r\n</ul>\r\n<p>Ce projet est situ&eacute; dans un quartier d&eacute;favoris&eacute;, quartier politique de la ville et de reconqu&ecirc;te r&eacute;publicaine, lieu d\'exercice des intervenants regroup&eacute;s au sein d\'un espace sant&eacute;.</p>'),
(4, 'partenaires', '<p>Parmi les partenaires du centre de sant&eacute; l\'&Eacute;toile, nous distinguons les financeurs et les partenaires op&eacute;rationnels et techniques. La Ville de Grenoble ainsi que l\'Assurance Maladie soutiennent le fonctionnement g&eacute;n&eacute;ral des centres de sant&eacute; ainsi que leur organisation et leur projet de sant&eacute;.</p>\r\n<p>D\'autres partenaires apportent un soutien financier &agrave; des actions sp&eacute;cifiques, notamment les actions de sant&eacute; publique et de pr&eacute;vention.</p>');

-- --------------------------------------------------------

--
-- Structure de la table `professionnels`
--

DROP TABLE IF EXISTS `professionnels`;
CREATE TABLE IF NOT EXISTS `professionnels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `id_activites` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `professionnels_ibfk_1` (`id_activites`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `professionnels`
--

INSERT INTO `professionnels` (`id`, `nom`, `id_activites`) VALUES
(14, 'Dr Saou Paul', 5),
(15, 'Dr Meunier Baptiste', 5),
(18, 'Camille Arnaud', 3),
(19, 'Derya Yucelir', 3),
(20, 'Raissa Evrat-Toupance', 4),
(21, 'Leslie Marsal', 4),
(22, 'Lucille Bourget', 4),
(23, 'Mariano Rosales', 8),
(24, 'AurÃ©lie Kodat', 7),
(25, 'NarimÃ¨ne Delloum', 7),
(26, 'LÃ©naic UrrÃ©a', 9);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$b5OxDem9mFzORruLI3dRzOXcc/zmFMN1JowqW.jNMr4Zb3pZd/u.2');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `professionnels`
--
ALTER TABLE `professionnels`
  ADD CONSTRAINT `professionnels_ibfk_1` FOREIGN KEY (`id_activites`) REFERENCES `activites` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
