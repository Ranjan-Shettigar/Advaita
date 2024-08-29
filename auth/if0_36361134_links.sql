-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql305.infinityfree.com
-- Generation Time: Aug 20, 2024 at 10:43 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_36361134_links`
--

-- --------------------------------------------------------

--
-- Table structure for table `deleted_links`
--

CREATE TABLE `deleted_links` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `deleted_links`
--

INSERT INTO `deleted_links` (`id`, `url`, `name`, `description`, `tags`, `deleted_at`, `username`, `email`, `password`) VALUES
(1, 'https://www.udio.com/', 'Udio', 'AI audio editing tool', 'AI, Audio, Editing', '2024-04-14 11:28:43', NULL, NULL, NULL),
(2, 'aa.com', 'aa', 'aa', 'aa', '2024-04-14 13:26:19', 'loko', 'lokotwiststudio2@gmail.com', '$2y$10$Cxo5uwgX5V/aPuuV5CcIyOj5wTUWhCUEgu79UPsJF.GqdlXRw7HFy'),
(3, 'Aa', 'Aa', '', '', '2024-04-15 02:48:15', 'loko', 'lokotwiststudio2@gmail.com', '$2y$10$Cxo5uwgX5V/aPuuV5CcIyOj5wTUWhCUEgu79UPsJF.GqdlXRw7HFy'),
(4, 'https://www.boat-lifestyle.com/', 'Buy Earbuds, Headphones, Earphones at Indiaâ€™s No.1 Earwear Brand: boAt', 'Check out the breathtaking collection of Earbuds, Headphones, Earphones &amp; Wireless Speakers with contemporary designs and best features from Indiaâ€™s No.1 Earwear Audio Brand - boAt Lifestyle.', '', '2024-04-15 19:21:46', 'loko', 'lokotwiststudio2@gmail.com', '$2y$10$Cxo5uwgX5V/aPuuV5CcIyOj5wTUWhCUEgu79UPsJF.GqdlXRw7HFy'),
(5, 'https://brave.com/', 'Secure, Fast, &amp; Private Web Browser with Adblocker | Brave', 'The Brave browser is a fast, private and secure web browser for PC, Mac and mobile. Download now to enjoy a faster ad-free browsing experience that saves data and battery life by blocking tracking software.', '', '2024-04-15 19:23:23', 'loko', 'lokotwiststudio2@gmail.com', '$2y$10$Cxo5uwgX5V/aPuuV5CcIyOj5wTUWhCUEgu79UPsJF.GqdlXRw7HFy'),
(10, 'https://writehuman.ai/', 'WriteHuman AI', 'AI writing assistant', 'AI, Writing', '2024-04-16 18:37:16', NULL, NULL, NULL),
(11, 'https://linksync.free.nf/', 'e', '', '', '2024-04-17 11:48:38', 'loko', 'lokotwiststudio2@gmail.com', '$2y$10$Cxo5uwgX5V/aPuuV5CcIyOj5wTUWhCUEgu79UPsJF.GqdlXRw7HFy'),
(12, 'https://docs.anthropic.com/en/prompt-library/library', 'Anthropic prompt', '', '', '2024-06-20 17:06:23', 'Theloko', 'lokotwiststudio@gmail.com', '$2y$10$0p7Sep0t6yZbPLu7hxAxLut8Fsu1IvAEAdMF6ZdDDTdTtwP3BZ6QS');

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `visibility` enum('public','private') NOT NULL DEFAULT 'public'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `url`, `name`, `description`, `tags`, `username`, `email`, `added_date`, `visibility`) VALUES
(1, 'https://www.chatpdf.com/', 'ChatPDF', 'Allows you to chat with AI assistants while viewing PDFs', 'AI, PDF, Chat', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(2, 'https://designer.microsoft.com/', 'Microsoft Designer', 'Design tool from Microsoft', 'Design, Graphics', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(3, 'https://chat.openai.com/', 'OpenAI Chat', 'Chat interface for OpenAI\'s language models', 'AI, Chat', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(4, 'https://labs.openai.com/', 'OpenAI Labs', 'Playground for testing OpenAI\'s AI models', 'AI, Experimentation', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(5, 'https://rytr.me/', 'Rytr', 'AI writing assistant', 'AI, Writing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(6, 'https://harpa.ai/', 'Harpa', 'AI writing tool', 'AI, Writing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(7, 'https://www.canva.com/', 'Canva', 'Graphic design tool', 'Design, Graphics', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(8, 'https://studio.polotno.com/', 'Polotno Studio', 'Online design and presentation tool', 'Design, Presentation', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(9, 'https://www.copy.ai/', 'Copy.ai', 'AI copywriting tool', 'AI, Writing, Copywriting', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(10, 'https://www.lalal.ai/', 'Lalal.ai', 'AI audio editing tool', 'AI, Audio', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(11, 'https://podcast.adobe.com/enhance', 'Adobe Podcast Enhance', 'Audio enhancement tool from Adobe', 'Audio, Editing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(12, 'https://uizard.io/', 'Uizard', 'AI design assistant', 'AI, Design', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(13, 'https://clipdrop.co/relight', 'Clipdrop Relight', 'AI video editing tool', 'AI, Video, Editing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(14, 'https://www.smartwriter.ai/', 'SmartWriter', 'AI writing assistant', 'AI, Writing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(15, 'https://playgroundai.com/create', 'PlaygroundAI', 'AI image generation tool', 'AI, Images', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(16, 'https://beta.tome.app/', 'Tome', 'AI note-taking and research assistant', 'AI, Notes, Research', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(17, 'https://marketplace.visualstudio.com/items?itemName=Safurai.Safurai', 'Safurai', 'AI code review extension for VS Code', 'AI, Code Review, VS Code', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(18, 'https://scribblediffusion.com/?utm_source=futurepedia&utm_medium=marketplace&utm_campaign=futurepedia', 'Scribble Diffusion', 'AI image generation from sketches', 'AI, Images, Sketches', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(19, 'https://lexica.art/aperture', 'Lexica Aperture', 'AI image generation and editing tool', 'AI, Images, Editing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(20, 'https://www.getconch.ai/bypass', 'Conch AI', 'AI bypass tool for Notion, Roam, and Craft', 'AI, Productivity, Bypass', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(21, 'https://www.codeconvert.ai/app', 'CodeConvert.ai', 'AI code converter', 'AI, Code, Conversion', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(22, 'https://magicstudio.com/magiceraser', 'Magic Eraser', 'AI image editing tool', 'AI, Images, Editing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(23, 'https://www.unscreen.com/', 'Unscreen', 'AI video background removal tool', 'AI, Video, Editing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(24, 'https://www.bluewillow.ai/', 'Bluewillow.ai', 'AI writing assistant', 'AI, Writing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(25, 'https://app.humata.ai/', 'Humata', 'AI research assistant', 'AI, Research', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(26, 'https://app.presentations.ai/docs/login', 'Presentations.AI', 'AI presentation creation tool', 'AI, Presentations', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(27, 'https://platform.openai.com/playground/p/default-explain-code', 'OpenAI Explain Code', 'AI code explanation tool from OpenAI', 'AI, Code, Explanation', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(28, 'https://www.perplexity.ai/', 'Perplexity AI', 'AI video editing and creation tool', 'AI, Video', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(29, 'https://www.reimaginehome.ai', 'ReImagine Home AI', 'AI home design tool', 'AI, Design, Home', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(30, 'https://app.simplified.com', 'Simplified', 'AI document summarization tool', 'AI, Summarization', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(31, 'https://docs.google.com/spreadsheets/u/0/d/1QCVpGC9F502lb8pbWBd5vD_VTjw9K9bAOsxILRab13c/htmlview', 'GoogleSheets Link', 'Shared Google Sheets link', 'Spreadsheets, Data', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(32, 'https://firefly.adobe.com/generate/images', 'Adobe Firefly Image Gen', 'AI image generation tool from Adobe', 'AI, Images', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(33, 'https://stunning.so', 'Stunning', 'AI design and presentation tool', 'AI, Design, Presentations', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(34, 'https://app.kaiber.ai', 'Kaiber.ai', 'AI writing assistant', 'AI, Writing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(35, 'https://app.leonardo.ai/', 'Leonardo.ai', 'AI code generation tool', 'AI, Code', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(36, 'https://spline.design/', 'Spline', '3D design and animation tool', '3D, Design, Animation', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(37, 'https://www.sincode.ai', 'SinCode.ai', 'AI programming assistant', 'AI, Programming', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(38, 'https://firefly.adobe.com/', 'Adobe Firefly', 'AI creative tools from Adobe', 'AI, Creative, Tools', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(39, 'https://fadr.com/', 'Fadr', 'AI facial animation tool', 'AI, Animation, Faces', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(40, 'https://chat.forefront.ai/', 'Forefront Chat', 'AI chat interface', 'AI, Chat', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(41, 'https://niomverse.com/ai-tools', 'NiomVerse AI Tools', 'Directory of AI tools', 'AI, Tools, Directory', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(42, 'https://studio.d-id.com', 'D-ID Studio', 'AI video editing and creation tool', 'AI, Video', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(43, 'https://colab.research.google.com/drive/1n-lGFGIrkJfV38G980sqmAa_5nLAzzj_?usp=sharing#scrollTo=ZOTu5AAS6A9I', 'Colab Notebook', 'Google Colab notebook link', 'Colab, Notebooks, Code', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(44, 'https://beta.elevenlabs.io/speech-synthesis', 'ElevenLabs', 'AI speech synthesis tool', 'AI, Speech, Synthesis', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(45, 'https://replicate.com/nightmareai', 'NightmareAI', 'AI image manipulation tool', 'AI, Images, Manipulation', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(46, 'https://app.wavtool.com/', 'Wavtool', 'Audio editing tool', 'Audio, Editing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(47, 'https://www.gptminus1.com/', 'GPTMinus1', 'AI text continuation tool', 'AI, Writing, Text', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(48, 'https://www.framer.com/ai', 'Framer AI', 'AI design and prototyping tool', 'AI, Design, Prototyping', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(49, 'https://huggingface.co/spaces/facebook/MusicGen', 'MusicGen', 'AI music generation tool', 'AI, Music', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(50, 'https://lumalabs.ai/dashboard/captures', 'Lumalabs Captures', 'AI video editing tool', 'AI, Video, Editing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(51, 'https://replicate.com/sczhou/codeformer', 'CodeFormer', 'AI code generation tool', 'AI, Code', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(52, 'https://simplified.com/', 'Simplified', 'AI writing and document assistant', 'AI, Writing, Documents', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(53, 'https://uizard.io/', 'Uizard', 'AI design tool', 'AI, Design', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(54, 'https://x-minus.pro/ai', 'X-Minus Pro', 'AI vocal removal tool', 'AI, Audio, Vocals', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(55, 'https://aws.amazon.com/codewhisperer/', 'AWS CodeWhisperer', 'AI code generation tool from AWS', 'AI, Code, AWS', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(56, 'https://github.com/Anjok07/ultimatevocalremovergui/releases/tag/v5.5.0', 'UltimateVocalRemoverGUI', 'Vocal removal tool', 'Audio, Vocals, Removal', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(57, 'https://wonderdynamics.com/', 'Wonder Dynamics', 'AI video editing and creation tool', 'AI, Video', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(58, 'https://claude.ai/chats', 'Claude.ai', 'AI chatbot interface', 'AI, Chat', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(59, 'https://www.promptvibes.com/', 'PromptVibes', 'AI prompt engineering tool', 'AI, Prompts', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(60, 'https://www.immerse.zone/', 'Immerse Zone', 'AI video editing and creation tool', 'AI, Video', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(61, 'https://ai-midi.com/', 'AI-MIDI', 'AI music generation tool', 'AI, Music', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(62, 'https://threatmap.checkpoint.com/', 'Threat Map', 'Cybersecurity threat map', 'Security, Threats', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(63, 'https://undetectable.ai/', 'Undetectable AI', 'AI content detector', 'AI, Content, Detection', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(64, 'https://www.vondy.com/', 'Vondy', 'AI video editing tool', 'AI, Video, Editing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(65, 'https://www.castmagic.io/', 'CastMagic', 'AI video creation tool', 'AI, Video', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(66, 'https://www.flux.ai', 'Flux AI', 'AI creative tools', 'AI, Creative, Tools', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(67, 'https://coproducer.output.com/pack-generator', 'CoProduer', 'AI music creation tool', 'AI, Music', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(68, 'https://www.widecanvas.ai/', 'WideCanvas AI', 'AI design tool', 'AI, Design', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(69, 'https://www.trickle.so/', 'Trickle', 'AI writing tool', 'AI, Writing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(70, 'https://www.blackbox.ai/', 'Blackbox AI', 'AI modeling and deployment platform', 'AI, Modeling, Deployment', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(71, 'https://makersuite.google.com/app/prompts/new_freeform', 'Google MakerSuite', 'AI prompt tool from Google', 'AI, Prompts', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(72, 'https://multimedia.easeus.com/vocal-remover/', 'EaseUS VocalRemover', 'Vocal removal tool', 'Audio, Vocals, Removal', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(73, 'https://ai.invideo.io/', 'InVideo AI', 'AI video editing tool', 'AI, Video, Editing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(74, 'https://riverside.fm/transcription#', 'Riverside Transcription', 'Audio transcription tool', 'Audio, Transcription', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(75, 'https://pro.splashmusic.com/generate', 'Splash Music', 'AI music generation tool', 'AI, Music', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(76, 'https://library.relume.io/dashboard', 'Relume Library', 'AI asset library', 'AI, Assets, Library', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(77, 'https://webflow.com/', 'Webflow', 'Website builder', 'Web Design, Builder', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(78, 'https://bubble.io/home', 'Bubble', 'No-code app builder', 'No-Code, Apps, Builder', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(79, 'https://riverside.fm/transcription', 'Riverside Transcription', 'Audio transcription tool', 'Audio, Transcription', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(80, 'https://testmail.app/', 'Testmail', 'Temporary email service', 'Email, Temporary', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(81, 'https://twoshot.app/', 'TwoShot', 'AI image editing tool', 'AI, Images, Editing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(82, 'https://app.kits.ai', 'Kits AI', 'AI writing assistant', 'AI, Writing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(83, 'https://rows.com/theloko/my-spreadsheets/untitled-2-5zuW4fjWOJvHQteELmo8YR/154f8215-689b-48c5-95d8-9ba6b6156490/view#table1', 'Rows', 'Spreadsheet tool', 'Spreadsheets, Data', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(84, 'https://app.durable.co', 'Durable', 'Note-taking and writing tool', 'Notes, Writing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(85, 'https://summarist.ai/', 'Summarist AI', 'Text summarization tool', 'AI, Summarization', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(86, 'https://www.aiprm.com/', 'AIPRM', 'AI project management tool', 'AI, Project Management', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(87, 'https://chrome.google.com/webstore/detail/merlin-1-click-access-to/camppjleccjaphfdbohjdohecfnoikec', 'Merlin Browser Extension', 'AI browser extension', 'AI, Browser, Extension', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(88, 'https://www.autodraw.com/', 'AutoDraw', 'AI drawing tool', 'AI, Drawing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(89, 'https://beta.character.ai/', 'Character AI', 'AI conversational agent', 'AI, Conversation', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(90, 'https://www.tidalflow.health/', 'Tidalflow', 'Health management platform', 'Health, Management', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(126, 'https://open.spotify.com/track/1pIwUYTGrEawD0cQMIuqc0', 'lost myself', 'Pdgu Â· Song Â· 2021', 'Loko', 'loko', 'lokotwiststudio2@gmail.com', '2024-04-17 07:58:36', 'private'),
(92, 'https://annotate.tv/', 'Annotate TV', 'Video annotation tool', 'Video, Annotation', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(93, 'https://answerthepublic.com/', 'Answer the Public', 'Keyword research tool', 'Keywords, Research', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(94, 'https://learningstudioai.com/?via=adk334&gad_source=1', 'Learning Studio AI', 'AI learning platform', 'AI, Learning', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(95, 'https://landing-8yljdqazy-humata.vercel.app/', 'Humata Landing', 'Humata AI landing page', 'AI, Landing Page', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(96, 'https://gamma.app/?lng=en', 'Gamma AI', 'AI writing tool', 'AI, Writing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(97, 'https://www.heygen.com/', 'Heygen', 'AI content creation tool', 'AI, Content', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(98, 'https://theresanaiforthat.com/', 'There\'s an AI for That', 'AI tool directory', 'AI, Tools, Directory', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(99, 'https://docs.google.com/spreadsheets/d/15oFP6am-k0cY8Bl_u9RuGgUeaLTOq_gbiA0GI8p6Q7M/edit?usp=drivesdk', 'Google Sheets', 'Shared Google Sheets link', 'Spreadsheets, Data', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(100, 'https://zapier.com/app/dashboard?context=18506946', 'Zapier Dashboard', 'Zapier automation platform', 'Automation, Integration', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(101, 'https://www.compose.ai/', 'Compose AI', 'AI writing assistant', 'AI, Writing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(102, 'https://sider.ai/', 'Sider AI', 'AI research assistant', 'AI, Research', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(103, 'https://www.grammarly.com/citations', 'Grammarly Citations', 'Citation tool', 'Writing, Citations', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(104, 'https://www.opus.pro/', 'Opus AI', 'AI writing assistant', 'AI, Writing', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(105, 'https://numerous.ai/', 'Numerous AI', 'AI assistant platform', 'AI, Assistants', NULL, NULL, '2024-04-14 10:55:15', 'public'),
(107, 'https://www.youtube.com/watch?v=7j76dlRnEpE', 'dddddff', 'fffffffffffffffff', 'fffffff', 'dhanu', 'dhanusha126@gmail.com', '2024-04-14 12:11:56', 'public'),
(109, 'https://docs.anthropic.com/claude/prompt-library', 'Prompt library', 'Explore optimized prompts for a breadth of business and personal tasks.', 'AI Prompt ', 'loko', 'lokotwiststudio2@gmail.com', '2024-04-14 18:07:58', 'public'),
(110, 'https://www.vvveb.com/vvvebjs/editor.html', 'Vveb website builder', 'Explore optimized prompts for a breadth of business and personal tasks.', 'Drag and drop website builder open source ', 'loko', 'lokotwiststudio2@gmail.com', '2024-04-15 02:44:30', 'public'),
(112, 'https://studio.grapesjs.com/', 'Grapesjs', 'Free and Open Source Web Builder Framework', 'Free and Open Source Web Builder Framework', 'loko', 'lokotwiststudio2@gmail.com', '2024-04-15 02:57:09', 'public'),
(113, 'https://builder.io/content', 'Website Builder', 'Explore optimized prompts for a breadth of business and personal tasks.', '', 'loko', 'lokotwiststudio2@gmail.com', '2024-04-15 03:13:55', 'public'),
(117, 'https://www.tensorflow.org/', 'TensorFlow', 'An end-to-end open source machine learning platform for everyone. Discover TensorFlow&#39;s flexible ecosystem of tools, libraries and community resources.', '', 'loko', 'lokotwiststudio2@gmail.com', '2024-04-15 19:48:15', 'public'),
(118, 'https://penpot.app/', 'Penpot: The Design Tool for Design &amp; Code Collaboration', 'Penpot is the open-source free design software that connects designers and developers with no handoff drama. Prototyping, UI design and code - all in one app. ', '', 'loko', 'lokotwiststudio2@gmail.com', '2024-04-16 02:05:22', 'public'),
(127, 'https://ollama.com/', 'Ollama', 'Get up and running with large language models.', '', 'loko', 'lokotwiststudio2@gmail.com', '2024-04-17 14:33:01', 'public'),
(122, 'https://platform.openai.com/playground', 'Openai playground ', '', '', NULL, NULL, '2024-04-16 18:37:11', 'public'),
(123, 'https://www.tabnine.com/', 'Tabnine is an AI assistant that speeds up delivery and keeps your code safe | Tabnine', 'Tabnine is an AI assistant that speeds up delivery and keeps your code safe', '', NULL, NULL, '2024-04-16 18:37:12', 'public'),
(124, 'https://www.recraft.ai/', 'Recraft', 'The first generative AI design tool that lets users create and edit digital illustrations, vector art, icons, and 3D graphics in a uniform brand style.', '', NULL, NULL, '2024-04-16 18:37:13', 'public'),
(128, 'https://arc.net/', 'Arc from The Browser Company', 'Experience a calmer, more personal internet in this browser designed for you. Let go of the clicks, the clutter, the distractions.', '', 'loko', 'lokotwiststudio2@gmail.com', '2024-04-18 11:03:05', 'public'),
(129, 'https://www.upscayl.org/', 'Upscayl - Free and Open Source AI Image Upscaler', '', '', 'loko', 'lokotwiststudio2@gmail.com', '2024-04-18 14:38:12', 'public'),
(130, 'https://www.relume.io', 'Relume', 'Ai webpage builder ', '', 'loko', 'lokotwiststudio2@gmail.com', '2024-04-18 14:40:10', 'public'),
(131, 'https://slater.app', 'Slater', 'Ai coding assistant ', '', 'loko', 'lokotwiststudio2@gmail.com', '2024-04-18 14:41:58', 'public'),
(132, 'https://openui.fly.dev/ai', 'Ai html', '', '', 'loko', 'lokotwiststudio2@gmail.com', '2024-04-18 15:58:59', 'public'),
(133, 'https://openui.fly.dev', 'Openui', 'Html css js', '', 'loko', 'lokotwiststudio2@gmail.com', '2024-04-18 15:59:27', 'public'),
(134, 'https://www.namecheap.com/', 'Namecheap', 'Domain ', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-04-21 15:45:48', 'public'),
(135, 'https://fn12.com/', 'FUNCTION12 - Get code just copy and paste', 'FUNCTION12 offers DevMode (Plus) and CodeGen, designed to automate and streamline the design-to-code process.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-04-21 16:09:50', 'public'),
(136, 'https://app.datacamp.com/', 'Datacamp', 'Online course ', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-04-21 16:10:50', 'public'),
(137, 'https://tensor.art/', 'FREE online image generator and model hosting site!', 'AI model sharing platform, online run models to generate image for free. Your can upload or download models, include Checkpoint, Embedding, ControlNet, LoRA. Also we offer some base model like Stable Diffusion 1.5 and XL to generate.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-03 13:54:20', 'public'),
(138, 'https://lensgo.ai/', 'Lensgo.ai', 'Anime video ', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-03 13:55:33', 'public'),
(139, 'https://www.eraser.io/', 'eraser.io', 'Er diagram ', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-04 04:27:22', 'public'),
(140, 'https://saveweb2zip.com/en', 'Saveweb2zip', 'Copy, clone website, landing page', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-08 03:13:43', 'public'),
(141, 'https://www.aitoolhunt.com/', 'Ai Tool Hunt - Best Free AI Tools 2024 | Ultimate List of AI Software &amp; Websites | AI Online Free', 'Explore the best free AI tools with our comprehensive AI tools list. Discover top-notch artificial intelligence tools, AI software, and AI websites to enhance your digital experience. Access powerful AI online for free and elevate your tech journey with the latest in AI innovations.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-08 08:08:48', 'public'),
(142, 'https://www.pdfescape.com/', 'Pdf escape ', 'Pdf editor ', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-08 08:22:24', 'public'),
(143, 'https://thenounproject.com/', 'The noun project ', 'Icons ', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-08 08:54:09', 'public'),
(144, 'https://www.tubeonai.com/', 'TubeOnAI: Instant YouTube &#38; Podcast Summaries in 30 Seconds', '', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-08 20:18:19', 'public'),
(145, 'https://lightning.ai', 'Lightning AI | Turn ideas into AI, Lightning fast', 'The all-in-one platform for AI development. Code together. Prototype. Train. Scale. Serve. From your browser - with zero setup. From the creators of PyTorch Lightning.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-09 19:08:54', 'public'),
(146, 'https://teachablemachine.withgoogle.com/', 'Teachable Machine', 'Train a computer to recognize your own images, sounds, & poses.                A fast, easy way to create machine learning models for your sites, apps, and more â€“ no expertise or coding required.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-09 20:02:32', 'public'),
(147, 'https://whimsical.com/ai', 'Whimsical AI diagrams', 'Generate flowcharts, sequence diagrams, &amp; mind maps in seconds. Use Whimsical AI to jump-start your first draft, brainstorm, or summarize web page content into diagrams.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-12 19:36:18', 'public'),
(148, 'https://www.windmill.dev/windmill_ai', 'Windmill', 'Windmill is a low-code platform for building endpoints, flows, and apps from simple scripts. Its design, centered around code, enables vast flexibility beyond just using pre-made integrations.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-14 17:07:19', 'public'),
(149, 'https://cursor.sh/cpp', 'Cursor', 'The AI-first Code Editor', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-16 03:10:27', 'public'),
(150, 'https://flutterflow.io', 'Flutterlow', 'Build applications faster than ever', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-17 08:09:23', 'public'),
(151, 'https://www.marsx.dev/', 'MarsX is a dev tool that unites AI, NoCode, Code and MicroApps', 'AI-powered coding platform (dev tool) to build SaaS tools in days! MarsX / MarsAI or Mars AI.', '', 'loko', 'lokotwiststudio2@gmail.com', '2024-05-23 15:29:58', 'public'),
(152, 'https://creatie.ai', 'Creatie | An AI empowered design tool for creatives', 'Product design made delightful with AI magic. Ideate, design, collaborate, prototype, handoff - all in one tool, all made easier and more joyful with AI.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-24 04:41:59', 'public'),
(153, 'https://lottiefiles.com', 'LottieFiles: Download Free lightweight animations for website &amp; apps.', 'Effortlessly bring the smallest, free, ready-to-use motion graphics for the web, app, social, and designs. Create, edit, test, collaborate, and ship Lottie animations in no time!', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-24 04:55:08', 'public'),
(154, 'https://bezi.com', 'Bezi', 'Explore optimized prompts for a breadth of business and personal tasks.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-24 04:57:17', 'public'),
(155, 'https://deco.cx/', 'deco.cx: the open-source, headless frontend platform', 'Deco.cx is the web builder for the post-AI era. Its an open-source, headless frontend platform that enables businesses to create authentic, high-performance digital experiences.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-28 05:25:07', 'public'),
(156, 'https://anvil.works', 'Anvil: Web Apps with Nothing but Python', 'Yes, really, nothing but Python! Anvil has a drag-and-drop editor, Python in the browser and on the server, and one-click deployment.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-05-28 05:36:55', 'public'),
(157, 'https://idx.google.com', 'Project IDX', 'Project IDX is an entirely web-based workspace for full-stack application development, complete with the latest generative AI from Gemini, and full-fidelity app previews, powered by cloud emulators.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-06-04 18:09:52', 'public'),
(158, 'https://chat.mistral.ai', 'mistral.ai', '', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-06-05 12:13:38', 'public'),
(159, 'https://www.tlbrowse.com/', 'Tlbrowse', 'Generate imagined websites on an infinite canvas', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-06-06 07:35:29', 'public'),
(160, 'https://www.figma.com', 'Figma: The Collaborative Interface Design Tool', 'Figma is the leading collaborative design tool for building meaningful products. Seamlessly design, prototype, develop, and collect feedback in a single platform.', '', 'llm', 'jepen79223@eqvox.com', '2024-06-07 06:45:24', 'public'),
(161, 'https://www.farfalle.dev/', 'Farfalle', 'Open-source AI powered answer engine.', '', 'llm', 'jepen79223@eqvox.com', '2024-06-08 05:58:06', 'public'),
(162, 'https://fixthephoto.com/online-photoshop-editor.html', 'Photoshop Online Editor', 'The best Photoshop online editor to let you edit images fast and professionally on your PC or laptop. ', '', 'llm', 'jepen79223@eqvox.com', '2024-06-17 17:43:50', 'public'),
(163, 'https://audiobox.metademolab.com/', 'Audiobox', 'Audiobox is Metaâ€™s new foundation research model for audio generation.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-06-20 16:58:58', 'public'),
(165, 'https://console.anthropic.com/workbench/953e407c-84ab-4e99-8665-466ba8f01cc6', 'Anthropic workbench', 'Anthropic', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-06-20 17:07:57', 'public'),
(166, 'https://platform.openai.com/docs/examples', 'Prompt examples', 'Explore what\'s possible with some example prompts', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-06-20 17:08:55', 'public'),
(167, 'https://www.krea.ai/home', 'Krea.ai', 'Si video ', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-06-22 12:47:06', 'public'),
(168, 'Suno.com', 'Suno', 'Audio', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-06-22 12:47:42', 'public'),
(169, 'https://bypassgpt.ai', 'Bypassgpt', 'Humanize AI Text and Bypass AI Detection With Our AI Humanizer', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-06-23 04:27:45', 'public'),
(170, 'https://www.mail-tester.com/', 'Newsletters spam test by mail-tester.com', 'mail-tester.com is a free online service that allows you to test your emails for Spam, Malformed Content and Mail Server Configuration problems', '', 'llm', 'jepen79223@eqvox.com', '2024-06-24 07:53:48', 'public'),
(171, 'https://www.bandlab.com/mastering', 'Bandlab Mastering. Fast, High Quality Online Mastering', 'Instantly master your tracks with the worldâ€™s leading online mastering service. Hear the difference mastering can make with the fastest, best sounding, and free artist-driven Mastering tool.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-06-24 12:19:49', 'public'),
(172, 'https://audimee.com', 'Audimee', 'Convert your vocals with our royalty-free voices, train your own voices, create copyright-free cover vocals, and much more.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-06-25 11:49:15', 'public'),
(173, 'https://dubverse.ai/', 'Online Video Dubbing with Dubverse.ai', 'Dubverse is an online video dubbing platform. Dubverse uses artificial intelligence to dub video across 30 languages at a lightning fast speed.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-06-27 05:00:36', 'public'),
(174, 'https://www.shodan.io', 'Shodan', 'Search engine of Internet-connected devices. Create a free account to get started.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-06-28 17:53:42', 'public'),
(175, 'https://app.flair.ai/', 'flair.ai', 'The AI design tool for product photo shoots ', '', 'llm', 'jepen79223@eqvox.com', '2024-07-02 05:34:37', 'public'),
(176, 'https://runwayml.com/', 'Runway - Advancing creativity with artificial intelligence.', 'Runway is an applied AI research company shaping the next era of art, entertainment and human creativity.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-07-02 20:42:53', 'public'),
(177, 'https://chat.lmsys.org/', 'LMSYS Chatbot Arena', 'Benchmarking LLMs and VLMs in the Wild', '', 'llm', 'jepen79223@eqvox.com', '2024-07-06 06:03:27', 'public'),
(178, 'https://huggingface.co/spaces/TencentARC/InstantMesh', 'InstantMesh - a Hugging Face Space by TencentARC', '', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-07-08 11:47:29', 'public'),
(179, 'https://www.ratatype.com/', 'Ratatype â€” Online Touch Typing Tutor and Typing Lessons', 'Learn how to type faster ðŸŽ¯. Take typing lessons on touch typing tutor Ratatype ðŸ’», practice your keyboarding skills online, take a typing speed test and get typing speed certificate for free.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-07-11 11:54:44', 'public'),
(180, 'https://storm.genie.stanford.edu/', 'Storm', 'An open-source research project from Stanford University to explore building AI systems to advance knowledge tasks and human learning.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-07-13 14:29:20', 'public'),
(181, 'https://scribehow.com/', 'scribehow', 'Turn any process into a step-by-step guide, instantly.', '', 'llm', 'jepen79223@eqvox.com', '2024-07-14 15:39:38', 'public'),
(182, 'https://www.vidnoz.com/', 'Vidnoz AI: Create FREE AI Videos 10X Faster Online', 'Vidnoz is the top free AI video generator platform, helping create videos with AI avatars, do face swaps, etc. Start making videos with Vidnoz AI tools now.', '', 'llm', 'jepen79223@eqvox.com', '2024-07-14 15:40:12', 'public'),
(183, 'https://www.popai.pro/', 'PopAi: Your Personal AI Workspace', 'A powerful AI tool that boosts productivity!Besides instant answers, explore search engine integration, PDF reading, Powerpoint generation and more! ', '', 'llm', 'jepen79223@eqvox.com', '2024-07-14 15:40:43', 'public'),
(184, 'https://fonts.ninja/', 'Discover, buy and download awesome fonts - Fonts Ninja', 'Fonts Ninja helps designers discover awesome fonts and create stunning designs. Explore thousands of fonts and download them for free or buy premium ones.', '', 'llm', 'jepen79223@eqvox.com', '2024-07-14 15:41:15', 'public'),
(185, 'https://www.scalenut.com/', 'scalenut', 'Your AI Co-pilot that powers the entire SEO content lifecycle', '', 'llm', 'jepen79223@eqvox.com', '2024-07-14 15:43:04', 'public'),
(186, 'https://selectext.app/', 'selectext', 'Copy text directly from videos with the Selectext browser extension', '', 'llm', 'jepen79223@eqvox.com', '2024-07-14 15:43:49', 'public'),
(187, 'https://free-for.dev/', 'Free for Developers', 'Developers and Open Source authors now have a massive amount of services offering free tiers, but it can be hard to find them all to make informed decisions.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-07-19 06:20:10', 'public'),
(188, 'https://notebooklm.google.com', 'Notebok LM', 'NotebookLM is your personalized AI research assistant powered by Google\'s most capable model, Gemini 1.5 Pro.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-07-22 02:27:19', 'public'),
(189, 'https://aitestkitchen.withgoogle.com', 'Image fx', 'Experiment at the intersection of AI and creativity', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-07-22 02:33:44', 'public'),
(190, 'https://fontawesome.com/', 'Font Awesome', 'The internet&#39;s icon library + toolkit. Used by millions of designers, devs, &amp; content creators. Open-source. Always free. Always awesome.', '', 'llm', 'jepen79223@eqvox.com', '2024-07-22 17:06:10', 'public'),
(191, 'https://labs.google.com', 'LABS.GOOGLE', 'Labs.Google is Googleâ€™s home for the latest AI tools, technology and discourse.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-07-29 14:51:32', 'public'),
(192, 'https://www.morphic.sh/', 'Morphic', 'A fully open-source AI-powered answer engine with a generative UI.', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-08-02 04:49:50', 'public'),
(193, 'https://artifacts.e2b.dev/', 'Artifacts', '', '', 'Theloko', 'lokotwiststudio@gmail.com', '2024-08-10 14:21:39', 'public'),
(194, 'https://www.sejda.com/', 'Sejda', 'Easy, pleasant and productive PDF editor', 'PDF', 'llm', 'jepen79223@eqvox.com', '2024-08-17 11:32:34', 'public');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_requests`
--

CREATE TABLE `password_reset_requests` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `request_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `password_reset_requests`
--

INSERT INTO `password_reset_requests` (`id`, `email`, `request_time`, `ip_address`) VALUES
(1, 'kajog53409@lewenbo.com', '2024-05-04 06:13:37', '106.206.101.71'),
(2, 'lokotwiststudio2@gmail.com', '2024-05-04 09:44:13', '106.206.101.5'),
(3, 'biyewo9007@rehezb.com', '2024-05-04 18:02:38', '27.59.39.187'),
(4, 'biyewo9007@rehezb.com', '2024-05-04 18:03:43', '27.59.39.187'),
(5, 'lokotwiststudio2@gmail.com', '2024-05-04 18:31:42', '27.59.39.187'),
(6, 'raheyab811@deligy.com', '2024-05-04 18:54:27', '27.59.39.187'),
(7, 'raheyab811@deligy.com', '2024-05-04 18:56:10', '27.59.39.187'),
(8, 'lokotwiststudio2@gmail.com', '2024-05-05 02:57:28', '110.225.62.240'),
(9, 'lokotwiststudio2@gmail.com', '2024-05-11 02:54:41', '110.225.62.226'),
(10, 'lokotwiststudio@gmail.com', '2024-07-19 10:45:56', '106.206.113.217'),
(11, 'lokotwiststudio2@gmail.com', '2024-07-19 10:47:11', '106.206.113.217');

-- --------------------------------------------------------

--
-- Table structure for table `search_log`
--

CREATE TABLE `search_log` (
  `id` int(11) NOT NULL,
  `query` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(64) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `reset_token`) VALUES
(15, 'shree', 'ganeshsheregan123@gmail.com', '$2y$10$k1zZz3CZi5Krnu.oQUeRluhUbxv/6EVAcrU.jwTjpTW3C9HE1smLy', NULL),
(14, '1', '1@qwe.com', '$2y$10$mYIw.0Fh70LLkXIQWr6Fy.Oy2fDW3yWeuCWp3P3UPGFr8P0NmrN2S', NULL),
(12, 'loko', 'lokotwiststudio2@gmail.com', '$2y$10$pBolQkTFYm5jsReX061f5uGvgPpz9VQiS.08Spfsr9P/I8O5cuhz.', '152f4061c5ca1cd9797f7cb1c31fcc96'),
(17, 'Dhanush', 'dhanusha126@gmail.com', '$2y$10$N6pK9emklt/rA93dF4Y7pePXMNWPYWewQkdvsdMwsmziSEB35XJGS', NULL),
(21, 'Girish', 'conej38579@etopys.com', '$2y$10$cMkTifIEmMewpLixFe.JSeq5P7FVFyIVStuDAky.vBt5fxbIFVG8W', '7c53be970403ed2f2cfedb679c82e0e8'),
(19, 'Dhanusha621', 'dhanusha621@gmail.com', '$2y$10$W23enG3dpYhlkcqXgavx1uwfHezAn4CD7EwAbyG6l6NyDAerXtLci', NULL),
(20, 'Theloko', 'lokotwiststudio@gmail.com', '$2y$10$0p7Sep0t6yZbPLu7hxAxLut8Fsu1IvAEAdMF6ZdDDTdTtwP3BZ6QS', 'd2c807ed450be0ee359f877545eedc06'),
(22, 'Jamesbond', 'yonit75393@kravify.com', '$2y$10$YFrPIWJcyYA4Hn.FzTdZa.ySVc3dbwVvJyF.BdhtFhWThlKy5eGeK', NULL),
(23, '656', 'ranjanshettigar656@gmail.com', '$2y$10$CIkEusKrIGlSokUD7sYhm.oqmjCT6KxDs1Z0NQrknEpI22O.e6JOa', NULL),
(24, 'Pavan acharya ', 'pavanachar0123@gmail.com', '$2y$10$0un00NX93zpi2n0bR1Mj0.fmOKo8hxtmFoTbYgmBY2wOV.DfIjj2C', NULL),
(25, 'Srivatsa Tantry', 'srivatsa9513@gmail.com', '$2y$10$2xEo7HcNjTMmRGd/Os9sTOZXVstqUqRUa0jB4zKWv8kXqya0vP78u', NULL),
(26, 'kajog53409@lewenbo.com', 'kajog53409@lewenbo.com', '$2y$10$PhW5mwdjMLavX88fjFTsC.30Tk.srEcV67hOC6k9pejfsDolyXO0y', 'b99814b4801a54d16e775a76adcc2c9a'),
(27, 'biyewo9007@rehezb.com', 'biyewo9007@rehezb.com', '$2y$10$M6/ea7kh.ZyAbXd22FJ6nej/e3dE1B32fxx38ioX.zJUMlz.6fvXi', 'b78ce65b59f7a32ce634bacbf068fe5e'),
(28, 'raheyab811@deligy.com', 'raheyab811@deligy.com', '$2y$10$3yofES9VYZj.5XVnmbRWI./3g9oOscqwrJIm77PqM9j1gNaXuhn.e', '225e8d5266088964bfb2081456709ee2'),
(29, 'yahawo3148@huleos.com', 'yahawo3148@huleos.com', '$2y$10$7HpdCjBDHqEXJoDuWwp43.gT1dVsTpgKf4oDiqjPWhRAR7IincdcG', NULL),
(30, 'admin', '1417emerald@fthcapital.com', '$2y$10$1hPoi64oSkwUOqnpiu7I9u/pOSNa58Za4SGY53EM2eSNMtvtXN17O', NULL),
(31, 'llm', 'jepen79223@eqvox.com', '$2y$10$Xj8MUjLOBHmgsrwD/yHtxeOP320xWou9UaBGQf4z5eG8tzvt4qeii', NULL),
(32, 'testing', 'bahiso6625@qodiq.com', '$2y$10$MCzJJditTF0IKEJgGdF8TOaeZbHZr7H9Oqvhps2Qks7I4qZjamJR6', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deleted_links`
--
ALTER TABLE `deleted_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_requests`
--
ALTER TABLE `password_reset_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `search_log`
--
ALTER TABLE `search_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deleted_links`
--
ALTER TABLE `deleted_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `password_reset_requests`
--
ALTER TABLE `password_reset_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `search_log`
--
ALTER TABLE `search_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
