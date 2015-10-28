<html>
<head>
<title>External Decays</title>
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

<form method='post' action='ExternalDecays.php'>
 
<h2>External Decays</h2> 
 
<code>DecayHandler</code> is a base class for the external handling of 
decays. It is intended for normal particle decays, primarily 
<i>B</i> mesons and <i>tau</i>, and cannot be used to redirect 
decays of heavy resonances like <i>t</i> or <i>Z^0</i>. 
The user-written derived class is called if a pointer to it has 
been given with the 
<code><?php $filepath = $_GET["filepath"];
echo "<a href='ProgramFlow.php?filepath=".$filepath."' target='page'>";?>pythia.decayPtr()</a></code> 
method, where it also is specified which particles it will be called for. 
This particle information is accessible with the 
<code><?php $filepath = $_GET["filepath"];
echo "<a href='ParticleDataScheme.php?filepath=".$filepath."' target='page'>";?>doExternalDecay()</a></code> 
method. 
 
<p/> 
There is only one pure virtual method in <code>DecayHandler</code>, 
to do the decay: 
<a name="method1"></a>
<p/><strong>virtual bool DecayHandler::decay(vector&lt;int&gt;&amp; idProd, vector&lt;double&gt;&amp; mProd, vector&lt;Vec4&gt;&amp; pProd, int iDec, const Event&amp; event) &nbsp;</strong> <br/>
where 
<br/><code>argument</code><strong> idProd </strong>  :  is a list of particle PDG identity codes, 
   
<br/><code>argument</code><strong> mProd </strong>  :  is a list of their respective masses (in GeV), and 
   
<br/><code>argument</code><strong> pProd </strong>  :  is a list of their respective four-momenta. 
   
   
 
<p/> 
At input, these vectors each have size one, so that <code>idProd[0]</code>, 
<code>mProd[0]</code> and <code>pProd[0]</code> contain information on the 
particle that is to be decayed. At output, the vectors should have 
increased by the addition of all the decay products. Even if initially 
defined in the rest frame of the mother, the products should have been 
boosted so that their four-momenta add up to the <code>pProd[0]</code> of 
the decaying particle. 
 
<p/> 
Should it be of interest to know the prehistory of the decaying 
particle, e.g. to set some helicity information affecting the 
decay angular distribution, the full event record is available 
read-only, with info in which slot <code>iDec</code> the decaying particle 
is stored. 
 
<p/> 
The routine should return <code>true</code> if it managed the decay and 
<code>false</code> otherwise, in which case <code>Pythia</code> will try 
to do the decay itself. This e.g. means you can choose to do some decay 
channels yourself, and leave others to <code>Pythia</code>. To avoid 
double-counting, the channels you want to handle should be switched off 
in the <code>Pythia</code> particle database. In the beginning of the 
external <code>decay</code> method you should then return 
<code>false</code> with a probability given by the sum of the branching 
ratios for those channels you do not want to handle yourself. 
 
<p/> 
Note that the decay vertex is always set by <code>Pythia</code>, and that 
<i>B-Bbar</i> oscillations have already been taken into account, 
if they were switched on. Thus <code>idProd[0]</code> may be the opposite 
of <code>event[iDec].id()</code>, where the latter provides the code at 
production. 
 
<p/> 
A sample test program is available in <code>main17.cc</code>, providing 
a simple example of how to use this facility. 
 
<h3>EvtGen</h3> 
 
The external <i>B</i> and <i>C</i>-hadron decay program EvtGen 
performs a chain of decays, rather than single particle decays, to 
propagate helicity information throughout the chain. Consequently, 
EvtGen cannot be simply interfaced via the <code>DecayHandler</code> 
class. A special class, <code>EvtGenDecays</code>, is provided 
in <code>Pythia8Plugins</code> which can be called after an event has 
been generated, to perform all remaining decays via EvtGen. An example 
of how to use this class is provided in <code>main48.cc</code>. 
A more detailed discussion of some physics considerations, notably 
event weights for forced decays, can be found in 
<a href="../pdfdoc/evtgen.pdf">this note</a>. 
</body>
</html>
 
<!-- Copyright (C) 2015 Torbjorn Sjostrand --> 
