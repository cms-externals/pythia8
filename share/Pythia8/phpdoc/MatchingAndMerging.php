<html>
<head>
<title>Matching and Merging</title>
<link rel="stylesheet" type="text/css" href="pythia.css"/>
<link rel="shortcut icon" href="pythia32.gif"/>
</head>
<body>

<script language=javascript type=text/javascript>
function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target :((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text"))
{return false;}
}

document.onkeypress = stopRKey;
</script>
<?php
if($_POST['saved'] == 1) {
if($_POST['filepath'] != "files/") {
echo "<font color='red'>SETTINGS SAVED TO FILE</font><br/><br/>"; }
else {
echo "<font color='red'>NO FILE SELECTED YET.. PLEASE DO SO </font><a href='SaveSettings.php'>HERE</a><br/><br/>"; }
}
?>

<form method='post' action='MatchingAndMerging.php'>
 
<h2>Matching and Merging</h2> 
 
Starting from a Born-level leading-order (LO) process, higher orders 
can be included in various ways. The three basic approaches would be 
<ul> 
<li>A formal order-by-order perturbative calculation, in each order 
higher including graphs both with one particle more in the final 
state and with one loop more in the intermediate state. This is 
accurate to the order of the calculation, but gives no hint of 
event structures beyond that, with more particles in the final state. 
Today next-to-leading order (NLO) is standard, while 
next-to-next-to-leading order (NNLO) is coming. This approach 
thus is limited to few orders, and also breaks down in soft and 
collinear regions, which makes it unsuitable for matching to 
hadronization. 
</li> 
<li>Real emissions to several higher orders, but neglecting the 
virtual/loop corrections that should go with it at any given order. 
Thereby it is possible to allow for topologies with a large and 
varying number of partons, at the prize of not being accurate to any 
particular order. The approach also opens up for doublecounting, 
and as above breaks down in soft and colliner regions. 
</li> 
<li>The parton shower provides an approximation to higher orders, 
both real and virtual contributions for the emission of arbitrarily 
many particles. As such it is less accurate than either of the two 
above, at least for topologies of well separated partons, but it 
contains a physically sensible behaviour in the soft and collinear 
limits, and therefore matches well onto the hadronization stage. 
</li> 
</ul> 
Given the pros and cons, much of the effort in recent years has 
involved the development of different prescriptions to combine 
the methods above in various ways. 
 
<p/> 
The common traits of all combination methods are that matrix elements 
are used to describe the production of hard and well separated 
particles, and parton showers for the production of soft or collinear 
particles. What differs between the various approaches that have been 
proposed are which matrix elements are being used, how doublecounting 
is avoided, and how the transition from the hard to the soft regime 
is handled. These combination methods are typically referred to as 
"matching" or "merging" algorithms. There is some confusion about 
the distinction between the two terms, and so we leave it to the 
inventor/implementor of a particular scheme to choose and motivate 
the name given to that scheme. 
 
<p/> 
PYTHIA comes with methods, to be described next, that implement 
or support several different kind of algorithms. The field is 
open-ended, however: any external program can feed in 
<?php $filepath = $_GET["filepath"];
echo "<a href='LesHouchesAccord.php?filepath=".$filepath."' target='page'>";?>Les Houches events</a> that 
PYTHIA subsequently showers, adds multiparton interactions to, 
and hadronizes. These events afterwards can be reweighted and 
combined in any desired way. The maximum <i>pT</i> of the shower 
evolution is set by the Les Houches <code>scale</code>, on the one 
hand, and by the values of the <code>SpaceShower:pTmaxMatch</code>, 
<code>TimeShower:pTmaxMatch</code> and other parton-shower settings, 
on the other. Typically it is not possible to achieve perfect 
matching this way, given that the PYTHIA <i>pT</i> evolution 
variables are not likely to agree with the variables used for cuts 
in the external program. Often one can get close enough with simple 
means but, for an improved matching, 
<?php $filepath = $_GET["filepath"];
echo "<a href='UserHooks.php?filepath=".$filepath."' target='page'>";?>User Hooks</a> can be inserted to control 
the steps taken on the way, e.g. to veto those parton shower branchings 
that would doublecount emissions included in the matrix elements. 
 
<p/> 
Zooming in from the "anything goes" perspective, the list of relevent 
approaches actively supported is as follows. 
<ul> 
 
<li>For many/most resonance decays the first branching in the shower is 
merged with first-order matrix elements [<a href="Bibliography.php" target="page">Ben87, Nor01</a>]. This 
means that the emission rate is accurate to NLO, similarly to the POWHEG 
strategy (see below), but built into the 
<?php $filepath = $_GET["filepath"];
echo "<a href='TimelikeShowers.php?filepath=".$filepath."' target='page'>";?>timelike showers</a>. 
The angular orientation of the event after the first emission is only 
handled by the parton shower kinematics, however. Needless to say, 
this formalism is precisely what is tested by <i>Z^0</i> decays at 
LEP1, and it is known to do a pretty good job there. 
</li> 
 
<li>Also the <?php $filepath = $_GET["filepath"];
echo "<a href='SpacelikeShowers.php?filepath=".$filepath."' target='page'>";?>spacelike showers</a> 
contain a correction to first-order matrix elements, but only for the 
one-body-final-state processes 
<i>q qbar &rarr; gamma^*/Z^0/W^+-/h^0/H^0/A0/Z'0/W'+-/R0</i> 
[<a href="Bibliography.php" target="page">Miu99</a>] and <i>g g &rarr; h^0/H^0/A0</i>, and only to 
leading order. That is, it is equivalent to the POWHEG formalism for 
the real emission, but the prefactor "cross section normalization" 
is LO rather than NLO. Therefore this framework is less relevant, 
and has been superseded the following ones. 
</li> 
 
<li>The POWHEG strategy [<a href="Bibliography.php" target="page">Nas04</a>] provides a cross section 
accurate to NLO. The hardest emission is constructed with unit 
probability, based on the ratio of the real-emission matrix element 
to the Born-level cross section, and with a Sudakov factor derived 
from this ratio, i.e. the philosophy introduced in [<a href="Bibliography.php" target="page">Ben87</a>]. 
<br/>While POWHEG is a generic strategy, the POWHEG BOX 
[<a href="Bibliography.php" target="page">Ali10</a>] is an explicit framework, within which several 
processes are available. The code required for merging the PYTHIA 
showers with POWHEG input can be found in 
<code>include/Pythia8Plugins/PowHegHooks.h</code>, and is further 
described on a <?php $filepath = $_GET["filepath"];
echo "<a href='POWHEGMerging.php?filepath=".$filepath."' target='page'>";?>separate page</a>. 
A user example is found in <code>examples/main31</code>. 
</li> 
 
<li>The other traditional approach for NLO calculations is the 
MC@NLO one [<a href="Bibliography.php" target="page">Fri02</a>]. In it the shower emission probability, 
without its Sudakov factor, is subtracted from the real-emission 
matrix element to regularize divergences. It therefore requires a 
analytic knowledge of the way the shower populates phase space. 
The aMC@NLO package [<a href="Bibliography.php" target="page">Fre11</a>] offers an implementation for 
PYTHIA 8, developed by Paolo Torrielli and Stefano Frixione. The 
global-recoil option of the PYTHIA final-state shower has been 
constructed to be used for the above-mentioned subtraction. 
</li> 
 
<li>Multi-jet merging in the CKKW-L approach [<a href="Bibliography.php" target="page">Lon01</a>] 
is directly available. Its implementation, relevant parameters 
and test programs are documented on a 
<?php $filepath = $_GET["filepath"];
echo "<a href='CKKWLMerging.php?filepath=".$filepath."' target='page'>";?>separate page</a>. 
</li> 
 
<li>Multi-jet matching in the MLM approach [<a href="Bibliography.php" target="page">Man02, Man07</a>] 
is also available, either based on the ALPGEN or on the Madgraph 
variant, and with input events either from ALPGEN or from 
Madgraph. For details see 
<?php $filepath = $_GET["filepath"];
echo "<a href='JetMatching.php?filepath=".$filepath."' target='page'>";?>separate page</a>. 
</li> 
 
<li>Unitarised matrix element + parton shower merging (UMEPS) 
is directly available. Its implementation, relevant parameters 
and test programs are documented on a 
<?php $filepath = $_GET["filepath"];
echo "<a href='UMEPSMerging.php?filepath=".$filepath."' target='page'>";?>separate page</a>. 
</li> 
 
<li>Next-to-leading order multi-jet merging (in the NL3 and UNLOPS approaches) 
is directly available. Its implementation, relevant parameters 
and test programs are documented on a 
<?php $filepath = $_GET["filepath"];
echo "<a href='NLOMerging.php?filepath=".$filepath."' target='page'>";?>separate page</a>. 
</li> 
 
<li>Next-to-leading order jet matching in the FxFx approach 
is also available. For details see 
<?php $filepath = $_GET["filepath"];
echo "<a href='JetMatching.php?filepath=".$filepath."' target='page'>";?>separate page</a>. 
</li> 
 
</ul> 
 
<br/><br/><hr/> 
<h3>MC@NLO, jet matching, multi-jet merging and NLO merging with 
main89.cc</h3> 
 
A common Pythia main program for MC@NLO NLO+PS matching, MLM jet matching, 
FxFx (NLO) jet matching, CKKW-L merging, UMEPS merging and UNLOPS (NLO) 
merging is available through <code>main89.cc</code>, together with the input 
files <code>main89mlm.cmnd</code>, <code>main89fxfx.cmnd</code>, 
<code>main89ckkwl.cmnd</code>, <code>main89umeps.cmnd</code> and 
<code>main89unlops.cmnd</code>. The interface to MLM jet matching relies 
on MadGraph, while all other options of <code>main89.cc</code> use aMC@NLO 
input. 
 
<code>main89.cc</code> produces HepMC events [<a href="Bibliography.php" target="page">Dob01</a>], that can be 
histogrammed (e.g. using RIVET [<a href="Bibliography.php" target="page">Buc10</a>]), or used as input for a 
detector simulation. If the user is not familiar with HepMC analysis tools, it 
is possible to instead use Pythia's histogramming routines. For this, remove 
the lines referring to HepMC, and histogram events as illustrated (for CKKW-L) 
for the histogram <i>histPTFirstSum</i> in <code>main84.cc</code>, i.e. 
using <i>weight*normhepmc</i> as weight. 
 
<p/> 
All settings can be transferred to <code>main89.cc</code> through an input 
file. The input file is part of the command line input of 
<code>main89.cc</code>, i.e. you can execute <code>main89</code> with the 
command 
</p> 
<code>./main89 myInputFile.cmnd myhepmc.hepmc</code> 
</p> 
 
to read the input <code>myInputFile.cmnd</code> and produce the output file 
<code>myhepmc.hepmc</code> . Since <code>main89.cc</code> is currently a 
"front-end" for different types of matching/merging, we will briefly discuss 
the inputs for this sample program in the following. 
 
<h4>Inputs</h4> 
 
In its current form, <code>main89.cc</code> uses LHEF input to transfer 
(weighted) phase space points to Pythia. It is possible to include all 
parton multiplicities in one LHEF sample. If e.g. UMEPS merging for 
W-boson + up to two additional partons is to be performed, one LHE file 
containing W+zero, W+one and W+two parton events is required. 
 
<p/> 
All input settings are handed to <code>main89.cc</code> in the form of an 
input file. We have included the input settings files 
<p/> 
 &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; <code>main89mlm.cmnd</code>, which 
illustrates the MLM jet matching interface, 
<p/> 
 &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; <code>main89ckkwl.cmnd</code>, which 
illustrates the CKKW-L multi-jet merging interface, 
<p/> 
 &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;  <code>main89umeps.cmnd</code>, which 
illustrates the UMEPS multi-jet merging interface, and 
 <p/> 
 &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; <code>main89fxfx.cmnd</code>, which 
illustrates the FxFx NLO jet matching interface, 
<p/> 
 &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;  <code>main89unlops.cmnd</code>, which 
illustrates the UNLOPS multi-jet NLO merging interface. 
<p/> 
Other settings (e.g. using <code>main89.cc</code> as simple LO+PS or as MC@NLO 
interface) are of course possible. In the following, we will briefly explain 
how input for the five choices above are generated and handled. 
 
<h4>MLM jet matching with main89.cc</h4> 
 
For MLM jet matching, <code>main89.cc</code> currently relies on LHEF input 
from MadGraph. Due to the particular unweighting strategy performed in the 
generation of these inputs, the sample program starts by estimating the 
cross section. After this estimate, MLM jet matching within the Madgraph 
approach is performed in a second Pythia run. Example MLM settings can be 
found in <code>main89mlm.cmnd</code>. Please consult 
<?php $filepath = $_GET["filepath"];
echo "<a href='JetMatching.php?filepath=".$filepath."' target='page'>";?>Jet Matching</a> for more details. 
 
<h4>CKKW-L merging with main89.cc</h4> 
 
For CKKW-L merging, <code>main89.cc</code> currently relies on LHEF inputs 
generated with the leading-order mode of aMC@NLO (i.e. events should 
be generated with <code>./bin/generate_events aMC@LO</code>). 
No run to estimate the cross section estimate is needed. Example CKKW-L 
settings can be found in <code>main89ckkwl.cmnd</code>. Please consult 
<?php $filepath = $_GET["filepath"];
echo "<a href='CKKWLMerging.php?filepath=".$filepath."' target='page'>";?>CKKW-L merging</a> for more details. 
 
<h4>UMEPS merging with main89.cc</h4> 
 
For UMEPS merging, <code>main89.cc</code> currently relies on LHEF inputs 
generated with the leading-order mode of aMC@NLO as well (see above). 
<code>main89.cc</code> automatically assigns if an event will be used as 
"standard" event or as "subtractive" contribution. Example UMEPS 
settings can be found in <code>main89umeps.cmnd</code>. Please 
consult <?php $filepath = $_GET["filepath"];
echo "<a href='UMEPSMerging.php?filepath=".$filepath."' target='page'>";?>UMEPS merging</a> and 
<?php $filepath = $_GET["filepath"];
echo "<a href='CKKWLMerging.php?filepath=".$filepath."' target='page'>";?>CKKW-L merging</a> for more details. 
 
<h4>FxFx (NLO) jet matching with main89.cc</h4> 
 
For FxFx jet matching, <code>main89.cc</code> relies on MC@NLO input LHE 
files generated with aMC@NLO. To produce FxFx outputs in aMC@NLO, the settings 
<code>PYTHIA8  = parton_shower</code>, <code>3 = ickkw</code> and 
<code>x = ptj</code> are necessary in your aMC@NLO run card. Here, 
<code>x</code> is the value of the matching scale in FxFx, i.e. has be 
identical to <code>JetMatching:qCutME</code> in the Pythia inputs. 
Example FxFx settings for Pythia can be found in <code>main89fxfx.cmnd</code>. 
Please consult <?php $filepath = $_GET["filepath"];
echo "<a href='JetMatching.php?filepath=".$filepath."' target='page'>";?>Jet Matching</a> and 
<?php $filepath = $_GET["filepath"];
echo "<a href='aMCatNLOMatching.php?filepath=".$filepath."' target='page'>";?>aMC@NLO matching</a> for more details. 
 
 
<h4>UNLOPS (NLO) merging with main89.cc</h4> 
 
For UNLOPS merging, <code>main89.cc</code> currently relies on LHEF inputs 
generated with the aMC@NLO. The UNLOPS interface in <code>main89.cc</code> 
requires a) leading-order inputs generated with the leading-order mode of 
aMC@NLO, using the UNLOPS prescription, and b) next-to-leading-order inputs 
generated with the NLO mode of aMC@NLO, using the UNLOPS prescription. 
To produce UNLOPS outputs in aMC@NLO, the settings 
<code>PYTHIA8  = parton_shower</code>, <code>4 = ickkw</code> and 
<code>x = ptj</code> are necessary in your aMC@NLO run card. Here, 
<code>x</code> is the value of the merging scale in UNLOPS, i.e. 
has be identical to <code>Merging:TMS</code> in the Pythia inputs. 
<code>main89.cc</code> will then process NLO inputs and LO inputs 
consecutively, and will automatically assign if an event will be used as 
"standard" event or as "subtractive" contribution. Example UNLOPS 
settings can be found in <code>main89umeps.cmnd</code>. Please 
consult <?php $filepath = $_GET["filepath"];
echo "<a href='UNLOPSMerging.php?filepath=".$filepath."' target='page'>";?>UMEPS merging</a> and 
<?php $filepath = $_GET["filepath"];
echo "<a href='CKKWLMerging.php?filepath=".$filepath."' target='page'>";?>CKKW-L merging</a> for more details. 
 
</body>
</html>
 
<!-- Copyright (C) 2015 Torbjorn Sjostrand --> 
