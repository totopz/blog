-- MySQL dump 10.16  Distrib 10.1.19-MariaDB, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: 127.0.0.1
-- ------------------------------------------------------
-- Server version	10.1.19-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,1,'The Gift of Thriving Instead of Just Surviving','Every year around this time when everyone is getting excited about the holidays, you start seeing all of these really depressing articles coming out about surviving infertility during the holidays.\r\n\r\nI hate that! I want to offer you something different. I don\'t want you to just survive the holidays. I want you to THRIVE in the face of infertility, every day of the year.\r\n\r\nYes, it is true, this is an incredibly difficult time for couples who are struggling to get and stay pregnant. It\'s hard all the time, and it doesn\'t stop for the holiday season.  Everyone around you is talking about how blessed they are, updating Facebook with photos of the their happy families skiing in Colorado, and drinking eggnog. Meanwhile, you are still giving yourself shots, worrying about your FSH levels, trying to figure out how you can swing another day off work to make it to your RE appointment, and studiously not eating cookies or drinking champagne at the office holiday party. The 10 different photos of your friends\' adorable babies in elf costumes just add insult to injury.\r\n\r\nStruggling with infertility is challenging on every level, but what I want to share with you today is that we actually have the ability to decide just how hard it is for us. Yes. It is painful, but the reality is that you DO have the power to make it less impactful on your life today, right now.\r\n\r\nThis might be a new way of thinking about your life and your situation, but stay with me and take a minute to really think about this;\r\n\r\nThe Dali Lama said, that 99% of all suffering occurs in either in the past or the future.  What this is means, is that very little suffering actually occurs in the moment apart from physical pain. Either we are lamenting the past or worrying about the future.  We are thinking of all of our past failed attempt to get pregnant or worrying about how we are going to pay for this or if our husbands are going to leave us or whatever. All of these things either already happened or MIGHT happen in the future. Anytime we are not the present we are vulnerable to our minds torturing ourselves with worry or regret.  \r\n\r\nIm sure you are asking yourself, What the hell are you talking about?  I am infertile and I don\'t have any power over this whole messed up situation.\r\n\r\nWhile it\'s true that you can\'t will yourself into being pregnant (oh, if only!) in some ways, you do have power.\r\n\r\nHere is how:\r\n\r\nThe next time something upsetting happens (notice I didn\'t say to you this keeps you from being a victim of anything or anyone. Things happen. You can\'t change that, but you get to decide what to do with them.); you got your period again, you are ovulating and your partner is out of town, you just found out your FSH is 20 whatever.\r\n\r\nInstead of getting upset and retelling the story to everyone who will hear it or replaying it over and over in your head hoping to sort it out, just stop. Stop. Take a deep breath and ask yourself, am I in the present, past or future right now?  If you are in the present or past, take another couple of breaths and just put all of your attention right on your breath on right now.  The more you practice this 20 second exercise, the more you will be able to impact your suffering.\r\n\r\nThe reality is that, when you obsess over the things that are difficult and sad in your life, you are chronically re-triggering distress emotions and suffering for yourself.  When we are in replay mode, we feel like we are doing something helpful or productive, but we are just thinking about what happened. And this thinking, while it may seem innocuous, is not very productive for your fertility or health.\r\n\r\nThe more time you spend overthinking-either in past\' mode or present mode\'- the more you cause stress to your system. Stress causes cortisol to go up and as we know, cortisol can negatively impact your ability to produce progesterone.  You desperately need progesterone to both get and stay pregnant, so you can see how reducing your experience of suffering has direct influence on your fertility.','2017-04-07 18:23:28'),(2,2,'Track Clinic: Everything You Need to Know to Master Sebring International Raceway','No American road-racing track resonates with as much history as Sebring. The Florida track\'s first race, a six-hour enduro on a makeshift course marked with hay bales, happened on the last day of 1950. Less than two years later, the track hosted the first 12 Hours of Sebring, the race that undeniably made it famous. With one exception, the 12 Hours has run every year since, most often as part of whatever prevailing international sports-car championship was in place. Even when it wasn\'t part of a series, though, Sebring attracted top-flight international teams that regarded its rugged pavement and hot weather as good durability testing for the 24 Hours of Le Mans. Winners have ranged from Fangio to Foyt to Fittipaldi, Gendebien to Gurney to Gregg, Moss to McLaren to McNish just about every post World War II racer of note. It\'s a cathedral of American motorsports and currently runs a variety of events ranging from the 12 Hours to various SCCA and NASA races, and even a ChumpCar event. So there\'s a reasonable opportunity for any of us to race where many motorsports legends have jockeyed their mounts.\r\n\r\nHistory\r\n\r\nShortly after World War II, aeronautical engineer, businessman, and MIT grad Alec Ulmann was looking for a place to pursue his idea of transforming surplus military planes into civilian aircraft. About 90 miles south of Orlando, smack in the middle of the Florida peninsula, he found the former Hendricks Field, where B-17, B-24, and B-29 crews trained during the war.\r\n\r\nUlmann soon converted the facility\'s runways, taxiways, and connecting roads into a racing circuit. The layout used for the first race had 12 turns and measured 3.5 miles. By the running of the inaugural 12 Hour race, a new configuration added five turns and increased the length to 5.2 miles.\r\n\r\nThough dead flat, the circuit was very challenging. The various roadways were confusing at night, and many of the turns had limited runoff. In the \'66 race, after one crash killed a driver and another, involving Mario Andretti, killed four spectators, the organizers altered the track to create more room for off-course excursions.\r\n\r\nIn 1983, 1987, 1991, and 1999, Sebring\'s owners repaved large portions of the track and revised the layout. As a result, the current lap length is down to 3.7 miles, but about 0.9 mile of the original coarse concrete and rough transitions still remain.\r\n\r\nSebring hosted the first United States Grand Prix in 1959, but it was too remote to garner much attention, attendance, or revenue. However, the track has been on the international sports-car calendar for most of its existence.','2017-04-07 18:26:16'),(3,3,'Classic Mini Remastered: Small Is Beautiful - And Very Expensive','Everything old is new again. Certainly in Britain, where the country\'s forthcoming Brexit from the European Union seems to have resulted in a dramatic spike in automotive nostalgia. We\'ve already told you about Jaguar Land Rover\'s plans to create Reborn factory restomod versions of various vehicles, most recently the Jaguar E-type. And now a smaller outfit, David Brown Automotive, is getting in on the act with a version of the original Mini. \r\n\r\nThe Mini Remastered will be based on the Issigonis-designed pre-BMW classic made by the now defunct Rover Group and its predecessors between 1959 and 2000. We\'re told that the Remastered Minis will use original VINs but will get new body shells and panels and will feature such unlikely additions as a touchscreen interface, new controls, a keyless ignition, and retrimmed cabins.\r\n\r\nThe mechanical changes are considerably more modest, with the Remastered Minis sticking with a modestly reworked version of the pushrod A-series engine, producing about 77 horsepower in basic tune and up to 97 in the hopped-up Inspired by Monte Carlo edition. All Remastered Minis will stick with the original\'s sump-mounted four-speed manual gearbox, despite the fact that aftermarket five-speed conversions have been around for decades. Probably a good thing that extra sound deadening is included, too.\r\n\r\nIf you\'re thinking that means another restomod that\'s more about show than go, you\'re probably right. The new body shells are deseamed, without the characteristic lines that marked the welds for the front and rear fenders of the original Mini. They will also get LED lights, bullet style mirrors, and even the dashboard air vents that the original lacked for much of its long life. The emphasis on quality is such that we\'re told painting each car takes four weeks. The touchscreen is a Pioneer unit capable of running Apple CarPlay and Android Auto, for those who don\'t want to let their choice of a classic car distract from always-on connectivity.','2017-04-07 18:27:10'),(4,4,'2017 Chevrolet Cruze Hatchback Automatic','We at C/D are unabashed proponents of the hatchback body style. Such cars generally offer more practical space than their sedan counterparts, and we also enjoy the slightly esoteric vibe they exude, at least in America where they are vastly outnumbered by more workaday crossovers, sedans, and SUVs. When Chevrolet introduced its Cruze compact for the 2011 model year, we hoped a hatchback would be part of the plan. Sadly, it wasn\'t to be even though Chevrolet developed a Cruze hatch for the European market in 2012. When the smoothly styled second-generation Cruze made its debut for 2016, there still was no hatchback in sight. Those crafty product planners clung to a sedan-only strategy for one more year, finally granting the Cruze five-door a U.S. visa starting with the 2017 model year.\r\n\r\nFirst Impressions\r\n\r\nAs we pointed out in our first drive of the hatchback Cruze, it doesn\'t stray far from the sedan in terms of styling, powertrain, and suspension. Most of what\'s different is behind the rear doors, where the extended roofline combines with the liftgate to provide 25 cubic feet (47 with the rear seats folded) of easily accessed storage behind the rear seats, compared with 15 cubes in the sedan\'s trunk. The wheelbase is the same at 106.3 inches, although overall length is down by 8.4 inches, to 175.3 inches.','2017-04-07 18:29:45'),(5,4,'How Much Would a Kia Be Worth Without the Kia Logo?','I can\'t even tell you how many times I\'ve been driving around and have uttered the words, Man that\'s a pretty car. I might want one if it had a different logo on the grille.\r\n\r\nIsn\'t branding a funny thing?\r\n\r\nThrow a BMW logo on a Hyundai and suddenly the practical $30,000 Korean sedan looks like a $50,000 German luxury car. So much of the value we put on a car comes from the perception of the logo adorning its front and back ends.\r\n\r\nI\'ve long wondered why, once Kia came out with its modern and sexy car designs, it kept the same logo from the 1990s that people associated with ultra-cheap basic transportation. Seeing a beautiful car with the clunky Kia logo can immediately take $10,000 away from its perceived value.\r\n\r\nKia may have finally gotten the message and will remove the logo from an upcoming performance sedan, at least in its home market. Will that translate to more buyers?\r\n\r\nThe car in question is the upcoming 2018 Kia Stinger, which will be sold around the world. While the U.S. version might still have the familiar and slightly off-putting Kia oval, other markets may not.','2017-04-07 18:30:48'),(6,2,'Faraday\'s Future in Question as Financial Fears Rise','Faraday Future still hasn\'t built a car and already its death watch has begun.\r\n\r\nPremature death isn\'t necessarily uncommon or unprecedented in the auto industry. Starting a car manufacturing business is one of the hardest endeavors to begin because of the outrageous costs of entry, strict government regulations, and long timeline to profitability.\r\n\r\nMany of the new car companies that have been attempted eventually fail. It\'s a sad truth, and we\'ve lost some exceptional innovation in the last century of auto manufacturing.\r\n\r\nFaraday Future may end up on the long list of failed and forgotten car companies by the end of the decade if the company continues down the path it appears to be following.\r\n\r\nFaraday began with promises of an automotive revolution and was surrounded with exceptional hype. Shrouded in mystery, all we knew was that a Chinese billionaire had invested in the startup American automaker. As time passed, the company unveiled a couple of concepts to mild acclaim and promised a 3-million-square-foot manufacturing plant in the Nevada desert along with a second plant in the Bay Area of California.\r\n\r\nBut those promises are facing some stark realities. One plant is completely off the table, and another has stopped before it even got started, much like the automaker itself.\r\n\r\nIs this is a sign of what\'s to come?\r\n\r\nPlans for the Bay Area plant have been cancelled, or at least temporarily shelved, while the Nevada plant appears to be in severe financial trouble.','2017-04-07 18:31:10');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `last_online` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','$2y$08$yAOzIgmxrK1pHChbwfoeA..ZI368AIIswt463jdkqDLqqq74wiXQG','Admin','2017-04-07 20:42:06','2017-04-07 11:16:54'),(2,'ivan','$2y$08$/yMUqGiaNwBFTJYwU5w0OOPIoZJWQkzSIhZYaqupSudCG7CDqD.kG','Ivan Marinov',NULL,'2017-04-07 20:30:14'),(3,'gerogi','$2y$08$d0mR9OBTusuhENxsAML8N.iTDO3SSzIBOzd8vfFlNFcMZ2wZ4pwuO','Georgi Popov',NULL,'2017-04-07 20:38:28'),(4,'marin','$2y$08$jVnFJtWCpXf5kXlrXxIgbOJH9WyOacJZQ8wA6FQTy8CbycfET/AFe','Marin Dimov',NULL,'2017-04-07 20:42:06');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-07 20:44:21
