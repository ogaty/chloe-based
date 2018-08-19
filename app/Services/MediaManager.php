<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Contracts\FileMoverInterface;
use App\Contracts\UploadedFilesInterface;

/**
 * Class MediaManager.
 */
class MediaManager implements FileMoverInterface
{
    /**
     * @var FilesystemAdapter
     */
    protected $disk;

    /**
     * Access Mode of the file as S3 uploads are private by default.
     *
     * @var string
     */
    protected $access;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * Name of the disk to upload to.
     *
     * @var string
     */
    private $diskName;

    /**
     * Label of the breadcrumb's root.
     *
     * @var string
     */
    // from apache-mime-types
    protected $extensionToType = array(
        'atom' => 'application/atom+xml',
        'epub' => 'application/epub+zip',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'doc' => 'application/msword',
        'bin' => 'application/octet-stream',
        'dms' => 'application/octet-stream',
        'lrf' => 'application/octet-stream',
        'mar' => 'application/octet-stream',
        'so' => 'application/octet-stream',
        'dist' => 'application/octet-stream',
        'distz' => 'application/octet-stream',
        'pkg' => 'application/octet-stream',
        'bpk' => 'application/octet-stream',
        'dump' => 'application/octet-stream',
        'elc' => 'application/octet-stream',
        'deploy' => 'application/octet-stream',
        'oda' => 'application/oda',
        'opf' => 'application/oebps-package+xml',
        'ogx' => 'application/ogg',
        'omdoc' => 'application/omdoc+xml',
        'onetoc' => 'application/onenote',
        'onetoc2' => 'application/onenote',
        'onetmp' => 'application/onenote',
        'onepkg' => 'application/onenote',
        'oxps' => 'application/oxps',
        'xer' => 'application/patch-ops-error+xml',
        'pdf' => 'application/pdf',
        'pgp' => 'application/pgp-encrypted',
        'asc' => 'application/pgp-signature',
        'sig' => 'application/pgp-signature',
        'prf' => 'application/pics-rules',
        'p10' => 'application/pkcs10',
        'p7m' => 'application/pkcs7-mime',
        'p7c' => 'application/pkcs7-mime',
        'p7s' => 'application/pkcs7-signature',
        'p8' => 'application/pkcs8',
        'ac' => 'application/pkix-attr-cert',
        'cer' => 'application/pkix-cert',
        'crl' => 'application/pkix-crl',
        'pkipath' => 'application/pkix-pkipath',
        'pki' => 'application/pkixcmp',
        'pls' => 'application/pls+xml',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',
        'cww' => 'application/prs.cww',
        'pskcxml' => 'application/pskc+xml',
        'rdf' => 'application/rdf+xml',
        'rif' => 'application/reginfo+xml',
        'rnc' => 'application/relax-ng-compact-syntax',
        'rl' => 'application/resource-lists+xml',
        'rld' => 'application/resource-lists-diff+xml',
        'rs' => 'application/rls-services+xml',
        'gbr' => 'application/rpki-ghostbusters',
        'mft' => 'application/rpki-manifest',
        'roa' => 'application/rpki-roa',
        'rsd' => 'application/rsd+xml',
        'rss' => 'application/rss+xml',
        'rtf' => 'application/rtf',
        'sbml' => 'application/sbml+xml',
        'scq' => 'application/scvp-cv-request',
        'scs' => 'application/scvp-cv-response',
        'spq' => 'application/scvp-vp-request',
        'spp' => 'application/scvp-vp-response',
        'sdp' => 'application/sdp',
        'setpay' => 'application/set-payment-initiation',
        'setreg' => 'application/set-registration-initiation',
        'shf' => 'application/shf+xml',
        'smi' => 'application/smil+xml',
        'smil' => 'application/smil+xml',
        'rq' => 'application/sparql-query',
        'srx' => 'application/sparql-results+xml',
        'gram' => 'application/srgs',
        'grxml' => 'application/srgs+xml',
        'sru' => 'application/sru+xml',
        'ssdl' => 'application/ssdl+xml',
        'ssml' => 'application/ssml+xml',
        'tei' => 'application/tei+xml',
        'teicorpus' => 'application/tei+xml',
        'tfi' => 'application/thraud+xml',
        'tsd' => 'application/timestamped-data',
        'plb' => 'application/vnd.3gpp.pic-bw-large',
        'psb' => 'application/vnd.3gpp.pic-bw-small',
        'pvb' => 'application/vnd.3gpp.pic-bw-var',
        'tcap' => 'application/vnd.3gpp2.tcap',
        'pwn' => 'application/vnd.3m.post-it-notes',
        'aso' => 'application/vnd.accpac.simply.aso',
        'imp' => 'application/vnd.accpac.simply.imp',
        'acu' => 'application/vnd.acucobol',
        'atc' => 'application/vnd.acucorp',
        'acutc' => 'application/vnd.acucorp',
        'air' => 'application/vnd.adobe.air-application-installer-package+zip',
        'fcdt' => 'application/vnd.adobe.formscentral.fcdt',
        'fxp' => 'application/vnd.adobe.fxp',
        'fxpl' => 'application/vnd.adobe.fxp',
        'xdp' => 'application/vnd.adobe.xdp+xml',
        'xfdf' => 'application/vnd.adobe.xfdf',
        'ahead' => 'application/vnd.ahead.space',
        'azf' => 'application/vnd.airzip.filesecure.azf',
        'azs' => 'application/vnd.airzip.filesecure.azs',
        'azw' => 'application/vnd.amazon.ebook',
        'acc' => 'application/vnd.americandynamics.acc',
        'ami' => 'application/vnd.amiga.ami',
        'apk' => 'application/vnd.android.package-archive',
        'cii' => 'application/vnd.anser-web-certificate-issue-initiation',
        'fti' => 'application/vnd.anser-web-funds-transfer-initiation',
        'atx' => 'application/vnd.antix.game-component',
        'mpkg' => 'application/vnd.apple.installer+xml',
        'm3u8' => 'application/vnd.apple.mpegurl',
        'swi' => 'application/vnd.aristanetworks.swi',
        'iota' => 'application/vnd.astraea-software.iota',
        'aep' => 'application/vnd.audiograph',
        'mpm' => 'application/vnd.blueice.multipass',
        'bmi' => 'application/vnd.bmi',
        'rep' => 'application/vnd.businessobjects',
        'cdxml' => 'application/vnd.chemdraw+xml',
        'mmd' => 'application/vnd.chipnuts.karaoke-mmd',
        'cdy' => 'application/vnd.cinderella',
        'cla' => 'application/vnd.claymore',
        'rp9' => 'application/vnd.cloanto.rp9',
        'c4g' => 'application/vnd.clonk.c4group',
        'c4d' => 'application/vnd.clonk.c4group',
        'c4f' => 'application/vnd.clonk.c4group',
        'c4p' => 'application/vnd.clonk.c4group',
        'c4u' => 'application/vnd.clonk.c4group',
        'c11amc' => 'application/vnd.cluetrust.cartomobile-config',
        'c11amz' => 'application/vnd.cluetrust.cartomobile-config-pkg',
        'csp' => 'application/vnd.commonspace',
        'cdbcmsg' => 'application/vnd.contact.cmsg',
        'cmc' => 'application/vnd.cosmocaller',
        'clkx' => 'application/vnd.crick.clicker',
        'clkk' => 'application/vnd.crick.clicker.keyboard',
        'clkp' => 'application/vnd.crick.clicker.palette',
        'clkt' => 'application/vnd.crick.clicker.template',
        'clkw' => 'application/vnd.crick.clicker.wordbank',
        'wbs' => 'application/vnd.criticaltools.wbs+xml',
        'pml' => 'application/vnd.ctc-posml',
        'ppd' => 'application/vnd.cups-ppd',
        'car' => 'application/vnd.curl.car',
        'pcurl' => 'application/vnd.curl.pcurl',
        'dart' => 'application/vnd.dart',
        'rdz' => 'application/vnd.data-vision.rdz',
        'uvf' => 'application/vnd.dece.data',
        'uvvf' => 'application/vnd.dece.data',
        'uvd' => 'application/vnd.dece.data',
        'uvvd' => 'application/vnd.dece.data',
        'uvt' => 'application/vnd.dece.ttml+xml',
        'uvvt' => 'application/vnd.dece.ttml+xml',
        'uvx' => 'application/vnd.dece.unspecified',
        'uvvx' => 'application/vnd.dece.unspecified',
        'uvz' => 'application/vnd.dece.zip',
        'uvvz' => 'application/vnd.dece.zip',
        'fe_launch' => 'application/vnd.denovo.fcselayout-link',
        'dna' => 'application/vnd.dna',
        'mlp' => 'application/vnd.dolby.mlp',
        'dpg' => 'application/vnd.dpgraph',
        'dfac' => 'application/vnd.dreamfactory',
        'kpxx' => 'application/vnd.ds-keypoint',
        'ait' => 'application/vnd.dvb.ait',
        'svc' => 'application/vnd.dvb.service',
        'geo' => 'application/vnd.dynageo',
        'mag' => 'application/vnd.ecowin.chart',
        'nml' => 'application/vnd.enliven',
        'esf' => 'application/vnd.epson.esf',
        'msf' => 'application/vnd.epson.msf',
        'qam' => 'application/vnd.epson.quickanime',
        'slt' => 'application/vnd.epson.salt',
        'ssf' => 'application/vnd.epson.ssf',
        'es3' => 'application/vnd.eszigno3+xml',
        'et3' => 'application/vnd.eszigno3+xml',
        'ez2' => 'application/vnd.ezpix-album',
        'ez3' => 'application/vnd.ezpix-package',
        'fdf' => 'application/vnd.fdf',
        'mseed' => 'application/vnd.fdsn.mseed',
        'seed' => 'application/vnd.fdsn.seed',
        'dataless' => 'application/vnd.fdsn.seed',
        'gph' => 'application/vnd.flographit',
        'ftc' => 'application/vnd.fluxtime.clip',
        'fm' => 'application/vnd.framemaker',
        'frame' => 'application/vnd.framemaker',
        'maker' => 'application/vnd.framemaker',
        'book' => 'application/vnd.framemaker',
        'fnc' => 'application/vnd.frogans.fnc',
        'ltf' => 'application/vnd.frogans.ltf',
        'fsc' => 'application/vnd.fsc.weblaunch',
        'oas' => 'application/vnd.fujitsu.oasys',
        'oa2' => 'application/vnd.fujitsu.oasys2',
        'oa3' => 'application/vnd.fujitsu.oasys3',
        'fg5' => 'application/vnd.fujitsu.oasysgp',
        'bh2' => 'application/vnd.fujitsu.oasysprs',
        'ddd' => 'application/vnd.fujixerox.ddd',
        'xdw' => 'application/vnd.fujixerox.docuworks',
        'xbd' => 'application/vnd.fujixerox.docuworks.binder',
        'fzs' => 'application/vnd.fuzzysheet',
        'txd' => 'application/vnd.genomatix.tuxedo',
        'ggb' => 'application/vnd.geogebra.file',
        'ggt' => 'application/vnd.geogebra.tool',
        'gex' => 'application/vnd.geometry-explorer',
        'gre' => 'application/vnd.geometry-explorer',
        'gxt' => 'application/vnd.geonext',
        'g2w' => 'application/vnd.geoplan',
        'g3w' => 'application/vnd.geospace',
        'gmx' => 'application/vnd.gmx',
        'kml' => 'application/vnd.google-earth.kml+xml',
        'kmz' => 'application/vnd.google-earth.kmz',
        'gqf' => 'application/vnd.grafeq',
        'gqs' => 'application/vnd.grafeq',
        'gac' => 'application/vnd.groove-account',
        'ghf' => 'application/vnd.groove-help',
        'gim' => 'application/vnd.groove-identity-message',
        'grv' => 'application/vnd.groove-injector',
        'gtm' => 'application/vnd.groove-tool-message',
        'tpl' => 'application/vnd.groove-tool-template',
        'vcg' => 'application/vnd.groove-vcard',
        'hal' => 'application/vnd.hal+xml',
        'zmm' => 'application/vnd.handheld-entertainment+xml',
        'hbci' => 'application/vnd.hbci',
        'les' => 'application/vnd.hhe.lesson-player',
        'hpgl' => 'application/vnd.hp-hpgl',
        'hpid' => 'application/vnd.hp-hpid',
        'hps' => 'application/vnd.hp-hps',
        'jlt' => 'application/vnd.hp-jlyt',
        'pcl' => 'application/vnd.hp-pcl',
        'pclxl' => 'application/vnd.hp-pclxl',
        'sfd-hdstx' => 'application/vnd.hydrostatix.sof-data',
        'mpy' => 'application/vnd.ibm.minipay',
        'afp' => 'application/vnd.ibm.modcap',
        'listafp' => 'application/vnd.ibm.modcap',
        'list3820' => 'application/vnd.ibm.modcap',
        'irm' => 'application/vnd.ibm.rights-management',
        'sc' => 'application/vnd.ibm.secure-container',
        'icc' => 'application/vnd.iccprofile',
        'icm' => 'application/vnd.iccprofile',
        'igl' => 'application/vnd.igloader',
        'ivp' => 'application/vnd.immervision-ivp',
        'ivu' => 'application/vnd.immervision-ivu',
        'igm' => 'application/vnd.insors.igm',
        'xpw' => 'application/vnd.intercon.formnet',
        'xpx' => 'application/vnd.intercon.formnet',
        'i2g' => 'application/vnd.intergeo',
        'qbo' => 'application/vnd.intu.qbo',
        'qfx' => 'application/vnd.intu.qfx',
        'rcprofile' => 'application/vnd.ipunplugged.rcprofile',
        'irp' => 'application/vnd.irepository.package+xml',
        'xpr' => 'application/vnd.is-xpr',
        'fcs' => 'application/vnd.isac.fcs',
        'jam' => 'application/vnd.jam',
        'rms' => 'application/vnd.jcp.javame.midlet-rms',
        'jisp' => 'application/vnd.jisp',
        'joda' => 'application/vnd.joost.joda-archive',
        'ktz' => 'application/vnd.kahootz',
        'ktr' => 'application/vnd.kahootz',
        'karbon' => 'application/vnd.kde.karbon',
        'chrt' => 'application/vnd.kde.kchart',
        'kfo' => 'application/vnd.kde.kformula',
        'flw' => 'application/vnd.kde.kivio',
        'kon' => 'application/vnd.kde.kontour',
        'kpr' => 'application/vnd.kde.kpresenter',
        'kpt' => 'application/vnd.kde.kpresenter',
        'ksp' => 'application/vnd.kde.kspread',
        'kwd' => 'application/vnd.kde.kword',
        'kwt' => 'application/vnd.kde.kword',
        'htke' => 'application/vnd.kenameaapp',
        'kia' => 'application/vnd.kidspiration',
        'kne' => 'application/vnd.kinar',
        'knp' => 'application/vnd.kinar',
        'skp' => 'application/vnd.koan',
        'skd' => 'application/vnd.koan',
        'skt' => 'application/vnd.koan',
        'skm' => 'application/vnd.koan',
        'sse' => 'application/vnd.kodak-descriptor',
        'lasxml' => 'application/vnd.las.las+xml',
        'lbd' => 'application/vnd.llamagraphics.life-balance.desktop',
        'lbe' => 'application/vnd.llamagraphics.life-balance.exchange+xml',
        '123' => 'application/vnd.lotus-1-2-3',
        'apr' => 'application/vnd.lotus-approach',
        'pre' => 'application/vnd.lotus-freelance',
        'nsf' => 'application/vnd.lotus-notes',
        'org' => 'application/vnd.lotus-organizer',
        'scm' => 'application/vnd.lotus-screencam',
        'lwp' => 'application/vnd.lotus-wordpro',
        'portpkg' => 'application/vnd.macports.portpkg',
        'mcd' => 'application/vnd.mcd',
        'mc1' => 'application/vnd.medcalcdata',
        'cdkey' => 'application/vnd.mediastation.cdkey',
        'mwf' => 'application/vnd.mfer',
        'mfm' => 'application/vnd.mfmp',
        'flo' => 'application/vnd.micrografx.flo',
        'igx' => 'application/vnd.micrografx.igx',
        'mif' => 'application/vnd.mif',
        'daf' => 'application/vnd.mobius.daf',
        'dis' => 'application/vnd.mobius.dis',
        'mbk' => 'application/vnd.mobius.mbk',
        'mqy' => 'application/vnd.mobius.mqy',
        'msl' => 'application/vnd.mobius.msl',
        'plc' => 'application/vnd.mobius.plc',
        'txf' => 'application/vnd.mobius.txf',
        'mpn' => 'application/vnd.mophun.application',
        'mpc' => 'application/vnd.mophun.certificate',
        'xul' => 'application/vnd.mozilla.xul+xml',
        'cil' => 'application/vnd.ms-artgalry',
        'cab' => 'application/vnd.ms-cab-compressed',
        'xls' => 'application/vnd.ms-excel',
        'xlm' => 'application/vnd.ms-excel',
        'xla' => 'application/vnd.ms-excel',
        'xlc' => 'application/vnd.ms-excel',
        'xlt' => 'application/vnd.ms-excel',
        'xlw' => 'application/vnd.ms-excel',
        'xlam' => 'application/vnd.ms-excel.addin.macroenabled.12',
        'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroenabled.12',
        'xlsm' => 'application/vnd.ms-excel.sheet.macroenabled.12',
        'xltm' => 'application/vnd.ms-excel.template.macroenabled.12',
        'eot' => 'application/vnd.ms-fontobject',
        'chm' => 'application/vnd.ms-htmlhelp',
        'ims' => 'application/vnd.ms-ims',
        'lrm' => 'application/vnd.ms-lrm',
        'thmx' => 'application/vnd.ms-officetheme',
        'cat' => 'application/vnd.ms-pki.seccat',
        'stl' => 'application/vnd.ms-pki.stl',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pps' => 'application/vnd.ms-powerpoint',
        'pot' => 'application/vnd.ms-powerpoint',
        'ppam' => 'application/vnd.ms-powerpoint.addin.macroenabled.12',
        'pptm' => 'application/vnd.ms-powerpoint.presentation.macroenabled.12',
        'sldm' => 'application/vnd.ms-powerpoint.slide.macroenabled.12',
        'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroenabled.12',
        'potm' => 'application/vnd.ms-powerpoint.template.macroenabled.12',
        'mpp' => 'application/vnd.ms-project',
        'mpt' => 'application/vnd.ms-project',
        'docm' => 'application/vnd.ms-word.document.macroenabled.12',
        'dotm' => 'application/vnd.ms-word.template.macroenabled.12',
        'wps' => 'application/vnd.ms-works',
        'wks' => 'application/vnd.ms-works',
        'wcm' => 'application/vnd.ms-works',
        'wdb' => 'application/vnd.ms-works',
        'wpl' => 'application/vnd.ms-wpl',
        'xps' => 'application/vnd.ms-xpsdocument',
        'mseq' => 'application/vnd.mseq',
        'mus' => 'application/vnd.musician',
        'msty' => 'application/vnd.muvee.style',
        'taglet' => 'application/vnd.mynfc',
        'nlu' => 'application/vnd.neurolanguage.nlu',
        'ntf' => 'application/vnd.nitf',
        'nitf' => 'application/vnd.nitf',
        'nnd' => 'application/vnd.noblenet-directory',
        'nns' => 'application/vnd.noblenet-sealer',
        'nnw' => 'application/vnd.noblenet-web',
        'ngdat' => 'application/vnd.nokia.n-gage.data',
        'n-gage' => 'application/vnd.nokia.n-gage.symbian.install',
        'rpst' => 'application/vnd.nokia.radio-preset',
        'rpss' => 'application/vnd.nokia.radio-presets',
        'edm' => 'application/vnd.novadigm.edm',
        'edx' => 'application/vnd.novadigm.edx',
        'ext' => 'application/vnd.novadigm.ext',
        'dd2' => 'application/vnd.oma.dd2+xml',
        'oxt' => 'application/vnd.openofficeorg.extension',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
        'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'mgp' => 'application/vnd.osgeo.mapguide.package',
        'dp' => 'application/vnd.osgi.dp',
        'esa' => 'application/vnd.osgi.subsystem',
        'pdb' => 'application/vnd.palm',
        'pqa' => 'application/vnd.palm',
        'oprc' => 'application/vnd.palm',
        'paw' => 'application/vnd.pawaafile',
        'str' => 'application/vnd.pg.format',
        'ei6' => 'application/vnd.pg.osasli',
        'efif' => 'application/vnd.picsel',
        'wg' => 'application/vnd.pmi.widget',
        'plf' => 'application/vnd.pocketlearn',
        'pbd' => 'application/vnd.powerbuilder6',
        'box' => 'application/vnd.previewsystems.box',
        'mgz' => 'application/vnd.proteus.magazine',
        'qps' => 'application/vnd.publishare-delta-tree',
        'ptid' => 'application/vnd.pvi.ptid1',
        'bed' => 'application/vnd.realvnc.bed',
        'mxl' => 'application/vnd.recordare.musicxml',
        'musicxml' => 'application/vnd.recordare.musicxml+xml',
        'cryptonote' => 'application/vnd.rig.cryptonote',
        'cod' => 'application/vnd.rim.cod',
        'rm' => 'application/vnd.rn-realmedia',
        'rmvb' => 'application/vnd.rn-realmedia-vbr',
        'link66' => 'application/vnd.route66.link66+xml',
        'st' => 'application/vnd.sailingtracker.track',
        'see' => 'application/vnd.seemail',
        'sema' => 'application/vnd.sema',
        'semd' => 'application/vnd.semd',
        'semf' => 'application/vnd.semf',
        'twd' => 'application/vnd.simtech-mindmapper',
        'twds' => 'application/vnd.simtech-mindmapper',
        'mmf' => 'application/vnd.smaf',
        'teacher' => 'application/vnd.smart.teacher',
        'sdkm' => 'application/vnd.solent.sdkm+xml',
        'sdkd' => 'application/vnd.solent.sdkm+xml',
        'dxp' => 'application/vnd.spotfire.dxp',
        'sfs' => 'application/vnd.spotfire.sfs',
        'smzip' => 'application/vnd.stepmania.package',
        'sm' => 'application/vnd.stepmania.stepchart',
        'susp' => 'application/vnd.sus-calendar',
        'svd' => 'application/vnd.svd',
        'sis' => 'application/vnd.symbian.install',
        'sisx' => 'application/vnd.symbian.install',
        'xsm' => 'application/vnd.syncml+xml',
        'bdm' => 'application/vnd.syncml.dm+wbxml',
        'xdm' => 'application/vnd.syncml.dm+xml',
        'tao' => 'application/vnd.tao.intent-module-archive',
        'pcap' => 'application/vnd.tcpdump.pcap',
        'cap' => 'application/vnd.tcpdump.pcap',
        'dmp' => 'application/vnd.tcpdump.pcap',
        'tmo' => 'application/vnd.tmobile-livetv',
        'tpt' => 'application/vnd.trid.tpt',
        'mxs' => 'application/vnd.triscape.mxs',
        'tra' => 'application/vnd.trueapp',
        'ufd' => 'application/vnd.ufdl',
        'ufdl' => 'application/vnd.ufdl',
        'utz' => 'application/vnd.uiq.theme',
        'umj' => 'application/vnd.umajin',
        'unityweb' => 'application/vnd.unity',
        'uoml' => 'application/vnd.uoml+xml',
        'torrent' => 'application/x-bittorrent',
        'blb' => 'application/x-blorb',
        'blorb' => 'application/x-blorb',
        'bz' => 'application/x-bzip',
        'bz2' => 'application/x-bzip2',
        'boz' => 'application/x-bzip2',
        'cbr' => 'application/x-cbr',
        'cba' => 'application/x-cbr',
        'cbt' => 'application/x-cbr',
        'cbz' => 'application/x-cbr',
        'cb7' => 'application/x-cbr',
        'vcd' => 'application/x-cdlink',
        'cfs' => 'application/x-cfs-compressed',
        'chat' => 'application/x-chat',
        'pgn' => 'application/x-chess-pgn',
        'nsc' => 'application/x-conference',
        'cpio' => 'application/x-cpio',
        'csh' => 'application/x-csh',
        'deb' => 'application/x-debian-package',
        'udeb' => 'application/x-debian-package',
        'dgc' => 'application/x-dgc-compressed',
        'dir' => 'application/x-director',
        'dcr' => 'application/x-director',
        'dxr' => 'application/x-director',
        'cst' => 'application/x-director',
        'cct' => 'application/x-director',
        'cxt' => 'application/x-director',
        'w3d' => 'application/x-director',
        'fgd' => 'application/x-director',
        'swa' => 'application/x-director',
        'wad' => 'application/x-doom',
        'ncx' => 'application/x-dtbncx+xml',
        'dtb' => 'application/x-dtbook+xml',
        'res' => 'application/x-dtbresource+xml',
        'dvi' => 'application/x-dvi',
        'evy' => 'application/x-envoy',
        'eva' => 'application/x-eva',
        'bdf' => 'application/x-font-bdf',
        'gsf' => 'application/x-font-ghostscript',
        'psf' => 'application/x-font-linux-psf',
        'otf' => 'application/x-font-otf',
        'pcf' => 'application/x-font-pcf',
        'snf' => 'application/x-font-snf',
        'ttf' => 'application/x-font-ttf',
        'ttc' => 'application/x-font-ttf',
        'pfa' => 'application/x-font-type1',
        'pfb' => 'application/x-font-type1',
        'pfm' => 'application/x-font-type1',
        'afm' => 'application/x-font-type1',
        'woff' => 'application/x-font-woff',
        'arc' => 'application/x-freearc',
        'spl' => 'application/x-futuresplash',
        'gca' => 'application/x-gca-compressed',
        'ulx' => 'application/x-glulx',
        'gnumeric' => 'application/x-gnumeric',
        'gramps' => 'application/x-gramps-xml',
        'gtar' => 'application/x-gtar',
        'hdf' => 'application/x-hdf',
        'install' => 'application/x-install-instructions',
        'iso' => 'application/x-iso9660-image',
        'jnlp' => 'application/x-java-jnlp-file',
        'latex' => 'application/x-latex',
        'lzh' => 'application/x-lzh-compressed',
        'lha' => 'application/x-lzh-compressed',
        'mie' => 'application/x-mie',
        'prc' => 'application/x-mobipocket-ebook',
        'mobi' => 'application/x-mobipocket-ebook',
        'application' => 'application/x-ms-application',
        'lnk' => 'application/x-ms-shortcut',
        'wmd' => 'application/x-ms-wmd',
        'wmz' => 'application/x-ms-wmz',
        'xbap' => 'application/x-ms-xbap',
        'mdb' => 'application/x-msaccess',
        'obd' => 'application/x-msbinder',
        'crd' => 'application/x-mscardfile',
        'clp' => 'application/x-msclip',
        'wmf' => 'application/x-msmetafile',
        'emf' => 'application/x-msmetafile',
        'emz' => 'application/x-msmetafile',
        'mny' => 'application/x-msmoney',
        'pub' => 'application/x-mspublisher',
        'scd' => 'application/x-msschedule',
        'trm' => 'application/x-msterminal',
        'wri' => 'application/x-mswrite',
        'nc' => 'application/x-netcdf',
        'cdf' => 'application/x-netcdf',
        'nzb' => 'application/x-nzb',
        'p12' => 'application/x-pkcs12',
        'pfx' => 'application/x-pkcs12',
        'p7b' => 'application/x-pkcs7-certificates',
        'spc' => 'application/x-pkcs7-certificates',
        'p7r' => 'application/x-pkcs7-certreqresp',
        'rar' => 'application/x-rar-compressed',
        'ris' => 'application/x-research-info-systems',
        'sh' => 'application/x-sh',
        'shar' => 'application/x-shar',
        'swf' => 'application/x-shockwave-flash',
        'xap' => 'application/x-silverlight-app',
        'sql' => 'application/x-sql',
        'sit' => 'application/x-stuffit',
        'sitx' => 'application/x-stuffitx',
        'srt' => 'application/x-subrip',
        'sv4cpio' => 'application/x-sv4cpio',
        'sv4crc' => 'application/x-sv4crc',
        't3' => 'application/x-t3vm-image',
        'gam' => 'application/x-tads',
        'tar' => 'application/x-tar',
        'tcl' => 'application/x-tcl',
        'tex' => 'application/x-tex',
        'tfm' => 'application/x-tex-tfm',
        'texinfo' => 'application/x-texinfo',
        'texi' => 'application/x-texinfo',
        'obj' => 'application/x-tgif',
        'ustar' => 'application/x-ustar',
        'src' => 'application/x-wais-source',
        'der' => 'application/x-x509-ca-cert',
        'crt' => 'application/x-x509-ca-cert',
        'fig' => 'application/x-xfig',
        'xlf' => 'application/x-xliff+xml',
        'xpi' => 'application/x-xpinstall',
        'xz' => 'application/x-xz',
        'xaml' => 'application/xaml+xml',
        'xdf' => 'application/xcap-diff+xml',
        'xenc' => 'application/xenc+xml',
        'xhtml' => 'application/xhtml+xml',
        'xht' => 'application/xhtml+xml',
        'xml' => 'application/xml',
        'xsl' => 'application/xml',
        'dtd' => 'application/xml-dtd',
        'xop' => 'application/xop+xml',
        'xpl' => 'application/xproc+xml',
        'xslt' => 'application/xslt+xml',
        'xspf' => 'application/xspf+xml',
        'mxml' => 'application/xv+xml',
        'xhvml' => 'application/xv+xml',
        'xvml' => 'application/xv+xml',
        'xvm' => 'application/xv+xml',
        'yang' => 'application/yang',
        'yin' => 'application/yin+xml',
        'zip' => 'application/zip',
        'adp' => 'audio/adpcm',
        'au' => 'audio/basic',
        'snd' => 'audio/basic',
        'mid' => 'audio/midi',
        'midi' => 'audio/midi',
        'kar' => 'audio/midi',
        'rmi' => 'audio/midi',
        'mp4a' => 'audio/mp4',
        'mpga' => 'audio/mpeg',
        'mp2' => 'audio/mpeg',
        'mp2a' => 'audio/mpeg',
        'mp3' => 'audio/mpeg',
        'm2a' => 'audio/mpeg',
        'm3a' => 'audio/mpeg',
        'oga' => 'audio/ogg',
        'ogg' => 'audio/ogg',
        'spx' => 'audio/ogg',
        's3m' => 'audio/s3m',
        'sil' => 'audio/silk',
        'uva' => 'audio/vnd.dece.audio',
        'uvva' => 'audio/vnd.dece.audio',
        'eol' => 'audio/vnd.digital-winds',
        'dra' => 'audio/vnd.dra',
        'dts' => 'audio/vnd.dts',
        'dtshd' => 'audio/vnd.dts.hd',
        'lvp' => 'audio/vnd.lucent.voice',
        'pya' => 'audio/vnd.ms-playready.media.pya',
        'ecelp4800' => 'audio/vnd.nuera.ecelp4800',
        'ecelp7470' => 'audio/vnd.nuera.ecelp7470',
        'ecelp9600' => 'audio/vnd.nuera.ecelp9600',
        'rip' => 'audio/vnd.rip',
        'weba' => 'audio/webm',
        'aac' => 'audio/x-aac',
        'aif' => 'audio/x-aiff',
        'aiff' => 'audio/x-aiff',
        'aifc' => 'audio/x-aiff',
        'caf' => 'audio/x-caf',
        'flac' => 'audio/x-flac',
        'mka' => 'audio/x-matroska',
        'm3u' => 'audio/x-mpegurl',
        'wax' => 'audio/x-ms-wax',
        'wma' => 'audio/x-ms-wma',
        'ram' => 'audio/x-pn-realaudio',
        'ra' => 'audio/x-pn-realaudio',
        'rmp' => 'audio/x-pn-realaudio-plugin',
        'wav' => 'audio/x-wav',
        'xm' => 'audio/xm',
        'cdx' => 'chemical/x-cdx',
        'cif' => 'chemical/x-cif',
        'cmdf' => 'chemical/x-cmdf',
        'cml' => 'chemical/x-cml',
        'csml' => 'chemical/x-csml',
        'xyz' => 'chemical/x-xyz',
        'bmp' => 'image/bmp',
        'cgm' => 'image/cgm',
        'g3' => 'image/g3fax',
        'gif' => 'image/gif',
        'ief' => 'image/ief',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'jpe' => 'image/jpeg',
        'ktx' => 'image/ktx',
        'png' => 'image/png',
        'btif' => 'image/prs.btif',
        'sgi' => 'image/sgi',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'psd' => 'image/vnd.adobe.photoshop',
        'uvi' => 'image/vnd.dece.graphic',
        'uvvi' => 'image/vnd.dece.graphic',
        'uvg' => 'image/vnd.dece.graphic',
        'uvvg' => 'image/vnd.dece.graphic',
        'sub' => 'image/vnd.dvb.subtitle',
        'djvu' => 'image/vnd.djvu',
        'djv' => 'image/vnd.djvu',
        'dwg' => 'image/vnd.dwg',
        'dxf' => 'image/vnd.dxf',
        'fbs' => 'image/vnd.fastbidsheet',
        'fpx' => 'image/vnd.fpx',
        'fst' => 'image/vnd.fst',
        'mmr' => 'image/vnd.fujixerox.edmics-mmr',
        'rlc' => 'image/vnd.fujixerox.edmics-rlc',
        'mdi' => 'image/vnd.ms-modi',
        'wdp' => 'image/vnd.ms-photo',
        'npx' => 'image/vnd.net-fpx',
        'wbmp' => 'image/vnd.wap.wbmp',
        'xif' => 'image/vnd.xiff',
        'webp' => 'image/webp',
        '3ds' => 'image/x-3ds',
        'ras' => 'image/x-cmu-raster',
        'cmx' => 'image/x-cmx',
        'ico' => 'image/x-icon',
        'sid' => 'image/x-mrsid-image',
        'pcx' => 'image/x-pcx',
        'pic' => 'image/x-pict',
        'pct' => 'image/x-pict',
        'pnm' => 'image/x-portable-anymap',
        'pbm' => 'image/x-portable-bitmap',
        'pgm' => 'image/x-portable-graymap',
        'ppm' => 'image/x-portable-pixmap',
        'rgb' => 'image/x-rgb',
        'tga' => 'image/x-tga',
        'xbm' => 'image/x-xbitmap',
        'xpm' => 'image/x-xpixmap',
        'xwd' => 'image/x-xwindowdump',
        'eml' => 'message/rfc822',
        'mime' => 'message/rfc822',
        'igs' => 'model/iges',
        'iges' => 'model/iges',
        'msh' => 'model/mesh',
        'mesh' => 'model/mesh',
        'silo' => 'model/mesh',
        'dae' => 'model/vnd.collada+xml',
        'dwf' => 'model/vnd.dwf',
        'gdl' => 'model/vnd.gdl',
        'gtw' => 'model/vnd.gtw',
        'mts' => 'model/vnd.mts',
        'vtu' => 'model/vnd.vtu',
        'wrl' => 'model/vrml',
        'vrml' => 'model/vrml',
        'x3db' => 'model/x3d+binary',
        'x3dbz' => 'model/x3d+binary',
        'x3dv' => 'model/x3d+vrml',
        'x3dvz' => 'model/x3d+vrml',
        'x3d' => 'model/x3d+xml',
        'x3dz' => 'model/x3d+xml',
        'appcache' => 'text/cache-manifest',
        'ics' => 'text/calendar',
        'ifb' => 'text/calendar',
        'css' => 'text/css',
        'csv' => 'text/csv',
        'html' => 'text/html',
        'htm' => 'text/html',
        'n3' => 'text/n3',
        'txt' => 'text/plain',
        'text' => 'text/plain',
        'conf' => 'text/plain',
        'def' => 'text/plain',
        'list' => 'text/plain',
        'log' => 'text/plain',
        'in' => 'text/plain',
        'dsc' => 'text/prs.lines.tag',
        'rtx' => 'text/richtext',
        'sgml' => 'text/sgml',
        'sgm' => 'text/sgml',
        'tsv' => 'text/tab-separated-values',
        't' => 'text/troff',
        'tr' => 'text/troff',
        'roff' => 'text/troff',
        'man' => 'text/troff',
        'me' => 'text/troff',
        'ms' => 'text/troff',
        'ttl' => 'text/turtle',
        'uri' => 'text/uri-list',
        'uris' => 'text/uri-list',
        'urls' => 'text/uri-list',
        'vcard' => 'text/vcard',
        'curl' => 'text/vnd.curl',
        'dcurl' => 'text/vnd.curl.dcurl',
        'scurl' => 'text/vnd.curl.scurl',
        'mcurl' => 'text/vnd.curl.mcurl',
        'fly' => 'text/vnd.fly',
        'flx' => 'text/vnd.fmi.flexstor',
        'gv' => 'text/vnd.graphviz',
        '3dml' => 'text/vnd.in3d.3dml',
        'spot' => 'text/vnd.in3d.spot',
        'jad' => 'text/vnd.sun.j2me.app-descriptor',
        'wml' => 'text/vnd.wap.wml',
        'wmls' => 'text/vnd.wap.wmlscript',
        's' => 'text/x-asm',
        'asm' => 'text/x-asm',
        'c' => 'text/x-c',
        'cc' => 'text/x-c',
        'cxx' => 'text/x-c',
        'cpp' => 'text/x-c',
        'h' => 'text/x-c',
        'hh' => 'text/x-c',
        'dic' => 'text/x-c',
        'f' => 'text/x-fortran',
        'for' => 'text/x-fortran',
        'f77' => 'text/x-fortran',
        'f90' => 'text/x-fortran',
        'java' => 'text/x-java-source',
        'opml' => 'text/x-opml',
        'p' => 'text/x-pascal',
        'pas' => 'text/x-pascal',
        'nfo' => 'text/x-nfo',
        'etx' => 'text/x-setext',
        'sfv' => 'text/x-sfv',
        'uu' => 'text/x-uuencode',
        'vcs' => 'text/x-vcalendar',
        'vcf' => 'text/x-vcard',
        '3gp' => 'video/3gpp',
        '3g2' => 'video/3gpp2',
        'h261' => 'video/h261',
        'h263' => 'video/h263',
        'h264' => 'video/h264',
        'jpgv' => 'video/jpeg',
        'jpm' => 'video/jpm',
        'jpgm' => 'video/jpm',
        'mj2' => 'video/mj2',
        'mjp2' => 'video/mj2',
        'mp4' => 'video/mp4',
        'mp4v' => 'video/mp4',
        'mpg4' => 'video/mp4',
        'mpeg' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mpe' => 'video/mpeg',
        'm1v' => 'video/mpeg',
        'm2v' => 'video/mpeg',
        'ogv' => 'video/ogg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        'uvh' => 'video/vnd.dece.hd',
        'uvvh' => 'video/vnd.dece.hd',
        'uvm' => 'video/vnd.dece.mobile',
        'uvvm' => 'video/vnd.dece.mobile',
        'uvp' => 'video/vnd.dece.pd',
        'uvvp' => 'video/vnd.dece.pd',
        'uvs' => 'video/vnd.dece.sd',
        'uvvs' => 'video/vnd.dece.sd',
        'uvv' => 'video/vnd.dece.video',
        'uvvv' => 'video/vnd.dece.video',
        'dvb' => 'video/vnd.dvb.file',
        'fvt' => 'video/vnd.fvt',
        'mxu' => 'video/vnd.mpegurl',
        'm4u' => 'video/vnd.mpegurl',
        'pyv' => 'video/vnd.ms-playready.media.pyv',
        'uvu' => 'video/vnd.uvvu.mp4',
        'uvvu' => 'video/vnd.uvvu.mp4',
        'viv' => 'video/vnd.vivo',
        'webm' => 'video/webm',
        'f4v' => 'video/x-f4v',
        'fli' => 'video/x-fli',
        'flv' => 'video/x-flv',
        'm4v' => 'video/x-m4v',
        'mkv' => 'video/x-matroska',
        'mk3d' => 'video/x-matroska',
        'mks' => 'video/x-matroska',
        'mng' => 'video/x-mng',
        'asf' => 'video/x-ms-asf',
        'asx' => 'video/x-ms-asf',
        'vob' => 'video/x-ms-vob',
        'wm' => 'video/x-ms-wm',
        'wmv' => 'video/x-ms-wmv',
        'wmx' => 'video/x-ms-wmx',
        'wvx' => 'video/x-ms-wvx',
        'avi' => 'video/x-msvideo',
        'movie' => 'video/x-sgi-movie',
        'smv' => 'video/x-smv',
        'ice' => 'x-conference/x-cooltalk',
    );

    protected $typeToExtensions = array(
        'application/andrew-inset' => array('ez'),
        'application/applixware' => array('aw'),
        'application/atom+xml' => array('atom'),
        'application/atomcat+xml' => array('atomcat'),
        'application/atomsvc+xml' => array('atomsvc'),
        'application/ccxml+xml' => array('ccxml'),
        'application/cdmi-capability' => array('cdmia'),
        'application/cdmi-container' => array('cdmic'),
        'application/cdmi-domain' => array('cdmid'),
        'application/cdmi-object' => array('cdmio'),
        'application/cdmi-queue' => array('cdmiq'),
        'application/cu-seeme' => array('cu'),
        'application/davmount+xml' => array('davmount'),
        'application/docbook+xml' => array('dbk'),
        'application/dssc+der' => array('dssc'),
        'application/dssc+xml' => array('xdssc'),
        'application/ecmascript' => array('ecma'),
        'application/emma+xml' => array('emma'),
        'application/epub+zip' => array('epub'),
        'application/exi' => array('exi'),
        'application/font-tdpfr' => array('pfr'),
        'application/gml+xml' => array('gml'),
        'application/gpx+xml' => array('gpx'),
        'application/gxf' => array('gxf'),
        'application/hyperstudio' => array('stk'),
        'application/inkml+xml' => array('ink', 'inkml'),
        'application/ipfix' => array('ipfix'),
        'application/java-archive' => array('jar'),
        'application/java-serialized-object' => array('ser'),
        'application/java-vm' => array('class'),
        'application/javascript' => array('js'),
        'application/json' => array('json'),
        'application/jsonml+json' => array('jsonml'),
        'application/lost+xml' => array('lostxml'),
        'application/mac-binhex40' => array('hqx'),
        'application/mac-compactpro' => array('cpt'),
        'application/mads+xml' => array('mads'),
        'application/marc' => array('mrc'),
        'application/marcxml+xml' => array('mrcx'),
        'application/mathematica' => array('ma', 'nb', 'mb'),
        'application/mathml+xml' => array('mathml'),
        'application/mbox' => array('mbox'),
        'application/mediaservercontrol+xml' => array('mscml'),
        'application/metalink+xml' => array('metalink'),
        'application/metalink4+xml' => array('meta4'),
        'application/mets+xml' => array('mets'),
        'application/mods+xml' => array('mods'),
        'application/mp21' => array('m21', 'mp21'),
        'application/mp4' => array('mp4s'),
        'application/msword' => array('doc', 'dot'),
        'application/mxf' => array('mxf'),
        'application/octet-stream' => array('bin', 'dms', 'lrf', 'mar', 'so', 'dist', 'distz', 'pkg', 'bpk', 'dump', 'elc', 'deploy'),
        'application/oda' => array('oda'),
        'application/oebps-package+xml' => array('opf'),
        'application/ogg' => array('ogx'),
        'application/omdoc+xml' => array('omdoc'),
        'application/onenote' => array('onetoc', 'onetoc2', 'onetmp', 'onepkg'),
        'application/oxps' => array('oxps'),
        'application/patch-ops-error+xml' => array('xer'),
        'application/pdf' => array('pdf'),
        'application/pgp-encrypted' => array('pgp'),
        'application/pgp-signature' => array('asc', 'sig'),
        'application/pics-rules' => array('prf'),
        'application/postscript' => array('ai', 'eps', 'ps'),
        'application/prs.cww' => array('cww'),
        'application/pskc+xml' => array('pskcxml'),
        'application/rdf+xml' => array('rdf'),
        'application/reginfo+xml' => array('rif'),
        'application/relax-ng-compact-syntax' => array('rnc'),
        'application/resource-lists+xml' => array('rl'),
        'application/resource-lists-diff+xml' => array('rld'),
        'application/rls-services+xml' => array('rs'),
        'application/rpki-ghostbusters' => array('gbr'),
        'application/rpki-manifest' => array('mft'),
        'application/rpki-roa' => array('roa'),
        'application/rsd+xml' => array('rsd'),
        'application/rss+xml' => array('rss'),
        'application/rtf' => array('rtf'),
        'application/sbml+xml' => array('sbml'),
        'application/scvp-cv-request' => array('scq'),
        'application/scvp-cv-response' => array('scs'),
        'application/scvp-vp-request' => array('spq'),
        'application/scvp-vp-response' => array('spp'),
        'application/sdp' => array('sdp'),
        'application/set-payment-initiation' => array('setpay'),
        'application/set-registration-initiation' => array('setreg'),
        'application/shf+xml' => array('shf'),
        'application/smil+xml' => array('smi', 'smil'),
        'application/sparql-query' => array('rq'),
        'application/sparql-results+xml' => array('srx'),
        'application/srgs' => array('gram'),
        'application/srgs+xml' => array('grxml'),
        'application/sru+xml' => array('sru'),
        'application/ssdl+xml' => array('ssdl'),
        'application/ssml+xml' => array('ssml'),
        'application/tei+xml' => array('tei', 'teicorpus'),
        'application/thraud+xml' => array('tfi'),
        'application/timestamped-data' => array('tsd'),
        'application/vnd.3gpp.pic-bw-large' => array('plb'),
        'application/vnd.3gpp.pic-bw-small' => array('psb'),
        'application/vnd.3gpp.pic-bw-var' => array('pvb'),
        'application/vnd.3gpp2.tcap' => array('tcap'),
        'application/vnd.3m.post-it-notes' => array('pwn'),
        'application/vnd.accpac.simply.aso' => array('aso'),
        'application/vnd.accpac.simply.imp' => array('imp'),
        'application/vnd.acucobol' => array('acu'),
        'application/vnd.acucorp' => array('atc', 'acutc'),
        'application/vnd.adobe.air-application-installer-package+zip' => array('air'),
        'application/vnd.adobe.formscentral.fcdt' => array('fcdt'),
        'application/vnd.adobe.fxp' => array('fxp', 'fxpl'),
        'application/vnd.adobe.xdp+xml' => array('xdp'),
        'application/vnd.adobe.xfdf' => array('xfdf'),
        'application/vnd.ahead.space' => array('ahead'),
        'application/vnd.airzip.filesecure.azf' => array('azf'),
        'application/vnd.airzip.filesecure.azs' => array('azs'),
        'application/vnd.amazon.ebook' => array('azw'),
        'application/vnd.americandynamics.acc' => array('acc'),
        'application/vnd.amiga.ami' => array('ami'),
        'application/vnd.android.package-archive' => array('apk'),
        'application/vnd.cluetrust.cartomobile-config' => array('c11amc'),
        'application/vnd.cluetrust.cartomobile-config-pkg' => array('c11amz'),
        'application/vnd.commonspace' => array('csp'),
        'application/vnd.contact.cmsg' => array('cdbcmsg'),
        'application/vnd.cosmocaller' => array('cmc'),
        'application/vnd.crick.clicker' => array('clkx'),
        'application/vnd.crick.clicker.keyboard' => array('clkk'),
        'application/vnd.crick.clicker.palette' => array('clkp'),
        'application/vnd.crick.clicker.template' => array('clkt'),
        'application/vnd.crick.clicker.wordbank' => array('clkw'),
        'application/vnd.criticaltools.wbs+xml' => array('wbs'),
        'application/vnd.ctc-posml' => array('pml'),
        'application/vnd.cups-ppd' => array('ppd'),
        'application/vnd.curl.car' => array('car'),
        'application/vnd.curl.pcurl' => array('pcurl'),
        'application/vnd.dart' => array('dart'),
        'application/vnd.data-vision.rdz' => array('rdz'),
        'application/vnd.dece.data' => array('uvf', 'uvvf', 'uvd', 'uvvd'),
        'application/vnd.dece.ttml+xml' => array('uvt', 'uvvt'),
        'application/vnd.dece.unspecified' => array('uvx', 'uvvx'),
        'application/vnd.dece.zip' => array('uvz', 'uvvz'),
        'application/vnd.denovo.fcselayout-link' => array('fe_launch'),
        'application/vnd.dna' => array('dna'),
        'application/vnd.dolby.mlp' => array('mlp'),
        'application/vnd.dpgraph' => array('dpg'),
        'application/vnd.dreamfactory' => array('dfac'),
        'application/vnd.ds-keypoint' => array('kpxx'),
        'application/vnd.dvb.ait' => array('ait'),
        'application/vnd.dvb.service' => array('svc'),
        'application/vnd.dynageo' => array('geo'),
        'application/vnd.ecowin.chart' => array('mag'),
        'application/vnd.enliven' => array('nml'),
        'application/vnd.epson.esf' => array('esf'),
        'application/vnd.epson.msf' => array('msf'),
        'application/vnd.epson.quickanime' => array('qam'),
        'application/vnd.epson.salt' => array('slt'),
        'application/vnd.epson.ssf' => array('ssf'),
        'application/vnd.eszigno3+xml' => array('es3', 'et3'),
        'application/vnd.ezpix-album' => array('ez2'),
        'application/vnd.ezpix-package' => array('ez3'),
        'application/vnd.fdf' => array('fdf'),
        'application/vnd.fdsn.mseed' => array('mseed'),
        'application/vnd.fdsn.seed' => array('seed', 'dataless'),
        'application/vnd.flographit' => array('gph'),
        'application/vnd.fluxtime.clip' => array('ftc'),
        'application/vnd.framemaker' => array('fm', 'frame', 'maker', 'book'),
        'application/vnd.frogans.fnc' => array('fnc'),
        'application/vnd.frogans.ltf' => array('ltf'),
        'application/vnd.fsc.weblaunch' => array('fsc'),
        'application/vnd.fujitsu.oasys' => array('oas'),
        'application/vnd.fujitsu.oasys2' => array('oa2'),
        'application/vnd.fujitsu.oasys3' => array('oa3'),
        'application/vnd.fujitsu.oasysgp' => array('fg5'),
        'application/vnd.fujitsu.oasysprs' => array('bh2'),
        'application/vnd.fujixerox.ddd' => array('ddd'),
        'application/vnd.fujixerox.docuworks' => array('xdw'),
        'application/vnd.fujixerox.docuworks.binder' => array('xbd'),
        'application/vnd.fuzzysheet' => array('fzs'),
        'application/vnd.genomatix.tuxedo' => array('txd'),
        'application/vnd.geogebra.file' => array('ggb'),
        'application/vnd.geogebra.tool' => array('ggt'),
        'application/vnd.geometry-explorer' => array('gex', 'gre'),
        'application/vnd.geonext' => array('gxt'),
        'application/vnd.geoplan' => array('g2w'),
        'application/vnd.geospace' => array('g3w'),
        'application/vnd.gmx' => array('gmx'),
        'application/vnd.google-earth.kml+xml' => array('kml'),
        'application/vnd.google-earth.kmz' => array('kmz'),
        'application/vnd.grafeq' => array('gqf', 'gqs'),
        'application/vnd.groove-account' => array('gac'),
        'application/vnd.groove-help' => array('ghf'),
        'application/vnd.groove-identity-message' => array('gim'),
        'application/vnd.groove-injector' => array('grv'),
        'application/vnd.groove-tool-message' => array('gtm'),
        'application/vnd.groove-tool-template' => array('tpl'),
        'application/vnd.groove-vcard' => array('vcg'),
        'application/vnd.hal+xml' => array('hal'),
        'application/vnd.handheld-entertainment+xml' => array('zmm'),
        'application/vnd.hbci' => array('hbci'),
        'application/vnd.hhe.lesson-player' => array('les'),
        'application/vnd.hp-hpgl' => array('hpgl'),
        'application/vnd.hp-hpid' => array('hpid'),
        'application/vnd.hp-hps' => array('hps'),
        'application/vnd.hp-jlyt' => array('jlt'),
        'application/vnd.hp-pcl' => array('pcl'),
        'application/vnd.hp-pclxl' => array('pclxl'),
        'application/vnd.hydrostatix.sof-data' => array('sfd-hdstx'),
        'application/vnd.ibm.minipay' => array('mpy'),
        'application/vnd.ibm.modcap' => array('afp', 'listafp', 'list3820'),
        'application/vnd.ibm.rights-management' => array('irm'),
        'application/vnd.ibm.secure-container' => array('sc'),
        'application/vnd.iccprofile' => array('icc', 'icm'),
        'application/vnd.igloader' => array('igl'),
        'application/vnd.immervision-ivp' => array('ivp'),
        'application/vnd.immervision-ivu' => array('ivu'),
        'application/vnd.insors.igm' => array('igm'),
        'application/vnd.intercon.formnet' => array('xpw', 'xpx'),
        'application/vnd.intergeo' => array('i2g'),
        'application/vnd.intu.qbo' => array('qbo'),
        'application/vnd.intu.qfx' => array('qfx'),
        'application/vnd.ipunplugged.rcprofile' => array('rcprofile'),
        'application/vnd.irepository.package+xml' => array('irp'),
        'application/vnd.is-xpr' => array('xpr'),
        'application/vnd.isac.fcs' => array('fcs'),
        'application/vnd.jam' => array('jam'),
        'application/vnd.jcp.javame.midlet-rms' => array('rms'),
        'application/vnd.jisp' => array('jisp'),
        'application/vnd.joost.joda-archive' => array('joda'),
        'application/vnd.kahootz' => array('ktz', 'ktr'),
        'application/vnd.kde.karbon' => array('karbon'),
        'application/vnd.kde.kchart' => array('chrt'),
        'application/vnd.kde.kformula' => array('kfo'),
        'application/vnd.kde.kivio' => array('flw'),
        'application/vnd.kde.kontour' => array('kon'),
        'application/vnd.kde.kpresenter' => array('kpr', 'kpt'),
        'application/vnd.kde.kspread' => array('ksp'),
        'application/vnd.kde.kword' => array('kwd', 'kwt'),
        'application/vnd.kenameaapp' => array('htke'),
        'application/vnd.kidspiration' => array('kia'),
        'application/vnd.kinar' => array('kne', 'knp'),
        'application/vnd.koan' => array('skp', 'skd', 'skt', 'skm'),
        'application/vnd.kodak-descriptor' => array('sse'),
        'application/vnd.las.las+xml' => array('lasxml'),
        'application/vnd.llamagraphics.life-balance.desktop' => array('lbd'),
        'application/vnd.llamagraphics.life-balance.exchange+xml' => array('lbe'),
        'application/vnd.macports.portpkg' => array('portpkg'),
        'application/vnd.mcd' => array('mcd'),
        'application/vnd.medcalcdata' => array('mc1'),
        'application/vnd.mediastation.cdkey' => array('cdkey'),
        'application/vnd.mfer' => array('mwf'),
        'application/vnd.mfmp' => array('mfm'),
        'application/vnd.micrografx.flo' => array('flo'),
        'application/vnd.micrografx.igx' => array('igx'),
        'application/vnd.mif' => array('mif'),
        'application/vnd.mophun.application' => array('mpn'),
        'application/vnd.mophun.certificate' => array('mpc'),
        'application/vnd.mozilla.xul+xml' => array('xul'),
        'application/vnd.ms-artgalry' => array('cil'),
        'application/vnd.ms-cab-compressed' => array('cab'),
        'application/vnd.ms-excel' => array('xls', 'xlm', 'xla', 'xlc', 'xlt', 'xlw'),
        'application/vnd.ms-excel.addin.macroenabled.12' => array('xlam'),
        'application/vnd.ms-excel.sheet.binary.macroenabled.12' => array('xlsb'),
        'application/vnd.ms-excel.sheet.macroenabled.12' => array('xlsm'),
        'application/vnd.ms-excel.template.macroenabled.12' => array('xltm'),
        'application/vnd.ms-fontobject' => array('eot'),
        'application/vnd.ms-htmlhelp' => array('chm'),
        'application/vnd.ms-ims' => array('ims'),
        'application/vnd.ms-lrm' => array('lrm'),
        'application/vnd.ms-officetheme' => array('thmx'),
        'application/vnd.ms-pki.seccat' => array('cat'),
        'application/vnd.ms-pki.stl' => array('stl'),
        'application/vnd.ms-powerpoint' => array('ppt', 'pps', 'pot'),
        'application/vnd.ms-powerpoint.addin.macroenabled.12' => array('ppam'),
        'application/vnd.ms-powerpoint.presentation.macroenabled.12' => array('pptm'),
        'application/vnd.ms-powerpoint.slide.macroenabled.12' => array('sldm'),
        'application/vnd.ms-powerpoint.slideshow.macroenabled.12' => array('ppsm'),
        'application/vnd.ms-powerpoint.template.macroenabled.12' => array('potm'),
        'application/vnd.ms-project' => array('mpp', 'mpt'),
        'application/vnd.ms-word.document.macroenabled.12' => array('docm'),
        'application/vnd.ms-word.template.macroenabled.12' => array('dotm'),
        'application/vnd.ms-works' => array('wps', 'wks', 'wcm', 'wdb'),
        'application/vnd.ms-wpl' => array('wpl'),
        'application/vnd.ms-xpsdocument' => array('xps'),
        'application/vnd.mseq' => array('mseq'),
        'application/vnd.musician' => array('mus'),
        'application/vnd.muvee.style' => array('msty'),
        'application/vnd.mynfc' => array('taglet'),
        'application/vnd.neurolanguage.nlu' => array('nlu'),
        'application/vnd.nitf' => array('ntf', 'nitf'),
        'application/vnd.noblenet-directory' => array('nnd'),
        'application/vnd.noblenet-sealer' => array('nns'),
        'application/vnd.noblenet-web' => array('nnw'),
        'application/vnd.nokia.n-gage.data' => array('ngdat'),
        'application/vnd.nokia.n-gage.symbian.install' => array('n-gage'),
        'application/vnd.nokia.radio-preset' => array('rpst'),
        'application/vnd.nokia.radio-presets' => array('rpss'),
        'application/vnd.novadigm.edm' => array('edm'),
        'application/vnd.novadigm.edx' => array('edx'),
        'application/vnd.novadigm.ext' => array('ext'),
        'application/vnd.olpc-sugar' => array('xo'),
        'application/vnd.oma.dd2+xml' => array('dd2'),
        'application/vnd.openofficeorg.extension' => array('oxt'),
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => array('pptx'),
        'application/vnd.openxmlformats-officedocument.presentationml.slide' => array('sldx'),
        'application/vnd.openxmlformats-officedocument.presentationml.slideshow' => array('ppsx'),
        'application/vnd.openxmlformats-officedocument.presentationml.template' => array('potx'),
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => array('xlsx'),
        'application/vnd.openxmlformats-officedocument.spreadsheetml.template' => array('xltx'),
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => array('docx'),
        'application/vnd.openxmlformats-officedocument.wordprocessingml.template' => array('dotx'),
        'application/vnd.osgeo.mapguide.package' => array('mgp'),
        'application/vnd.osgi.dp' => array('dp'),
        'application/vnd.osgi.subsystem' => array('esa'),
        'application/vnd.palm' => array('pdb', 'pqa', 'oprc'),
        'application/vnd.pawaafile' => array('paw'),
        'application/vnd.pg.format' => array('str'),
        'application/vnd.pg.osasli' => array('ei6'),
        'application/vnd.picsel' => array('efif'),
        'application/vnd.pmi.widget' => array('wg'),
        'application/vnd.pocketlearn' => array('plf'),
        'application/vnd.powerbuilder6' => array('pbd'),
        'application/vnd.previewsystems.box' => array('box'),
        'application/vnd.proteus.magazine' => array('mgz'),
        'application/vnd.publishare-delta-tree' => array('qps'),
        'application/vnd.pvi.ptid1' => array('ptid'),
        'application/vnd.quark.quarkxpress' => array('qxd', 'qxt', 'qwd', 'qwt', 'qxl', 'qxb'),
        'application/vnd.realvnc.bed' => array('bed'),
        'application/vnd.recordare.musicxml' => array('mxl'),
        'application/vnd.recordare.musicxml+xml' => array('musicxml'),
        'application/vnd.rig.cryptonote' => array('cryptonote'),
        'application/vnd.rim.cod' => array('cod'),
        'application/vnd.rn-realmedia' => array('rm'),
        'application/vnd.rn-realmedia-vbr' => array('rmvb'),
        'application/vnd.route66.link66+xml' => array('link66'),
        'application/vnd.sailingtracker.track' => array('st'),
        'application/vnd.seemail' => array('see'),
        'application/vnd.sema' => array('sema'),
        'application/vnd.semd' => array('semd'),
        'application/vnd.semf' => array('semf'),
        'application/vnd.shana.informed.formdata' => array('ifm'),
        'application/vnd.shana.informed.formtemplate' => array('itp'),
        'application/vnd.shana.informed.interchange' => array('iif'),
        'application/vnd.shana.informed.package' => array('ipk'),
        'application/vnd.simtech-mindmapper' => array('twd', 'twds'),
        'application/vnd.smaf' => array('mmf'),
        'application/vnd.smart.teacher' => array('teacher'),
        'application/vnd.solent.sdkm+xml' => array('sdkm', 'sdkd'),
        'application/vnd.spotfire.dxp' => array('dxp'),
        'application/vnd.spotfire.sfs' => array('sfs'),
        'application/vnd.stardivision.calc' => array('sdc'),
        'application/vnd.stardivision.draw' => array('sda'),
        'application/vnd.stardivision.impress' => array('sdd'),
        'application/vnd.stardivision.math' => array('smf'),
        'application/vnd.stardivision.writer' => array('sdw', 'vor'),
        'application/vnd.stardivision.writer-global' => array('sgl'),
        'application/vnd.stepmania.package' => array('smzip'),
        'application/vnd.stepmania.stepchart' => array('sm'),
        'application/vnd.sun.xml.calc' => array('sxc'),
        'application/vnd.sun.xml.calc.template' => array('stc'),
        'application/vnd.sun.xml.draw' => array('sxd'),
        'application/vnd.sun.xml.draw.template' => array('std'),
        'application/vnd.sun.xml.impress' => array('sxi'),
        'application/vnd.sun.xml.impress.template' => array('sti'),
        'application/vnd.sun.xml.math' => array('sxm'),
        'application/vnd.sun.xml.writer' => array('sxw'),
        'application/vnd.sun.xml.writer.global' => array('sxg'),
        'application/vnd.sun.xml.writer.template' => array('stw'),
        'application/vnd.sus-calendar' => array('sus', 'susp'),
        'application/vnd.svd' => array('svd'),
        'application/vnd.symbian.install' => array('sis', 'sisx'),
        'application/vnd.syncml+xml' => array('xsm'),
        'application/vnd.syncml.dm+wbxml' => array('bdm'),
        'application/vnd.syncml.dm+xml' => array('xdm'),
        'application/vnd.tao.intent-module-archive' => array('tao'),
        'application/vnd.tcpdump.pcap' => array('pcap', 'cap', 'dmp'),
        'application/vnd.tmobile-livetv' => array('tmo'),
        'application/vnd.trid.tpt' => array('tpt'),
        'application/vnd.triscape.mxs' => array('mxs'),
        'application/vnd.trueapp' => array('tra'),
        'application/vnd.ufdl' => array('ufd', 'ufdl'),
        'application/vnd.uiq.theme' => array('utz'),
        'application/vnd.umajin' => array('umj'),
        'application/vnd.unity' => array('unityweb'),
        'application/vnd.uoml+xml' => array('uoml'),
        'application/vnd.vcx' => array('vcx'),
        'application/vnd.visio' => array('vsd', 'vst', 'vss', 'vsw'),
        'application/vnd.visionary' => array('vis'),
        'application/vnd.vsf' => array('vsf'),
        'application/vnd.wap.wbxml' => array('wbxml'),
        'application/vnd.wap.wmlc' => array('wmlc'),
        'application/vnd.wap.wmlscriptc' => array('wmlsc'),
        'application/vnd.webturbo' => array('wtb'),
        'application/vnd.wolfram.player' => array('nbp'),
        'application/vnd.wordperfect' => array('wpd'),
        'application/vnd.wqd' => array('wqd'),
        'application/vnd.wt.stf' => array('stf'),
        'application/vnd.xara' => array('xar'),
        'application/vnd.xfdl' => array('xfdl'),
        'application/vnd.yamaha.hv-dic' => array('hvd'),
        'application/vnd.yamaha.hv-script' => array('hvs'),
        'application/vnd.yamaha.hv-voice' => array('hvp'),
        'application/vnd.yamaha.openscoreformat' => array('osf'),
        'application/vnd.yamaha.openscoreformat.osfpvg+xml' => array('osfpvg'),
        'application/vnd.yamaha.smaf-audio' => array('saf'),
        'application/vnd.yamaha.smaf-phrase' => array('spf'),
        'application/vnd.yellowriver-custom-menu' => array('cmp'),
        'application/vnd.zul' => array('zir', 'zirz'),
        'application/vnd.zzazz.deck+xml' => array('zaz'),
        'application/voicexml+xml' => array('vxml'),
        'application/widget' => array('wgt'),
        'application/winhlp' => array('hlp'),
        'application/wsdl+xml' => array('wsdl'),
        'application/wspolicy+xml' => array('wspolicy'),
        'application/x-7z-compressed' => array('7z'),
        'application/x-abiword' => array('abw'),
        'application/x-ace-compressed' => array('ace'),
        'application/x-apple-diskimage' => array('dmg'),
        'application/x-authorware-bin' => array('aab', 'x32', 'u32', 'vox'),
        'application/x-authorware-map' => array('aam'),
        'application/x-authorware-seg' => array('aas'),
        'application/x-bcpio' => array('bcpio'),
        'application/x-bittorrent' => array('torrent'),
        'application/x-blorb' => array('blb', 'blorb'),
        'application/x-bzip' => array('bz'),
        'application/x-bzip2' => array('bz2', 'boz'),
        'application/x-cbr' => array('cbr', 'cba', 'cbt', 'cbz', 'cb7'),
        'application/x-cdlink' => array('vcd'),
        'application/x-cfs-compressed' => array('cfs'),
        'application/x-chat' => array('chat'),
        'application/x-chess-pgn' => array('pgn'),
        'application/x-conference' => array('nsc'),
        'application/x-cpio' => array('cpio'),
        'application/x-csh' => array('csh'),
        'application/x-debian-package' => array('deb', 'udeb'),
        'application/x-dgc-compressed' => array('dgc'),
        'application/x-director' => array('dir', 'dcr', 'dxr', 'cst', 'cct', 'cxt', 'w3d', 'fgd', 'swa'),
        'application/x-doom' => array('wad'),
        'application/x-dtbncx+xml' => array('ncx'),
        'application/x-dtbook+xml' => array('dtb'),
        'application/x-dtbresource+xml' => array('res'),
        'application/x-dvi' => array('dvi'),
        'application/x-envoy' => array('evy'),
        'application/x-eva' => array('eva'),
        'application/x-font-bdf' => array('bdf'),
        'application/x-font-ghostscript' => array('gsf'),
        'application/x-font-linux-psf' => array('psf'),
        'application/x-font-otf' => array('otf'),
        'application/x-font-pcf' => array('pcf'),
        'application/x-font-snf' => array('snf'),
        'application/x-font-ttf' => array('ttf', 'ttc'),
        'application/x-font-type1' => array('pfa', 'pfb', 'pfm', 'afm'),
        'application/x-font-woff' => array('woff'),
        'application/x-freearc' => array('arc'),
        'application/x-futuresplash' => array('spl'),
        'application/x-gca-compressed' => array('gca'),
        'application/x-glulx' => array('ulx'),
        'application/x-gnumeric' => array('gnumeric'),
        'application/x-gramps-xml' => array('gramps'),
        'application/x-gtar' => array('gtar'),
        'application/x-hdf' => array('hdf'),
        'application/x-install-instructions' => array('install'),
        'application/x-iso9660-image' => array('iso'),
        'application/x-java-jnlp-file' => array('jnlp'),
        'application/x-latex' => array('latex'),
        'application/x-lzh-compressed' => array('lzh', 'lha'),
        'application/x-mie' => array('mie'),
        'application/x-mobipocket-ebook' => array('prc', 'mobi'),
        'application/x-ms-application' => array('application'),
        'application/x-ms-shortcut' => array('lnk'),
        'application/x-ms-wmd' => array('wmd'),
        'application/x-ms-wmz' => array('wmz'),
        'application/x-ms-xbap' => array('xbap'),
        'application/x-msaccess' => array('mdb'),
        'application/x-msbinder' => array('obd'),
        'application/x-mscardfile' => array('crd'),
        'application/x-msclip' => array('clp'),
        'application/x-msdownload' => array('exe', 'dll', 'com', 'bat', 'msi'),
        'application/x-msmediaview' => array('mvb', 'm13', 'm14'),
        'application/x-msmetafile' => array('wmf', 'wmz', 'emf', 'emz'),
        'application/x-msmoney' => array('mny'),
        'application/x-mspublisher' => array('pub'),
        'application/x-msschedule' => array('scd'),
        'application/x-msterminal' => array('trm'),
        'application/x-mswrite' => array('wri'),
        'application/x-netcdf' => array('nc', 'cdf'),
        'application/x-nzb' => array('nzb'),
        'application/x-pkcs12' => array('p12', 'pfx'),
        'application/x-pkcs7-certificates' => array('p7b', 'spc'),
        'application/x-pkcs7-certreqresp' => array('p7r'),
        'application/x-rar-compressed' => array('rar'),
        'application/x-research-info-systems' => array('ris'),
        'application/x-sh' => array('sh'),
        'application/x-shar' => array('shar'),
        'application/x-shockwave-flash' => array('swf'),
        'application/x-silverlight-app' => array('xap'),
        'application/x-sql' => array('sql'),
        'application/x-stuffit' => array('sit'),
        'application/x-stuffitx' => array('sitx'),
        'application/x-subrip' => array('srt'),
        'application/x-sv4cpio' => array('sv4cpio'),
        'application/x-sv4crc' => array('sv4crc'),
        'application/x-t3vm-image' => array('t3'),
        'application/x-tads' => array('gam'),
        'application/x-tar' => array('tar'),
        'application/x-tcl' => array('tcl'),
        'application/x-tex' => array('tex'),
        'application/x-tex-tfm' => array('tfm'),
        'application/x-texinfo' => array('texinfo', 'texi'),
        'application/x-tgif' => array('obj'),
        'application/x-ustar' => array('ustar'),
        'application/x-wais-source' => array('src'),
        'application/x-x509-ca-cert' => array('der', 'crt'),
        'application/x-xfig' => array('fig'),
        'application/x-xliff+xml' => array('xlf'),
        'application/x-xpinstall' => array('xpi'),
        'application/x-xz' => array('xz'),
        'application/x-zmachine' => array('z1', 'z2', 'z3', 'z4', 'z5', 'z6', 'z7', 'z8'),
        'application/xaml+xml' => array('xaml'),
        'application/xcap-diff+xml' => array('xdf'),
        'application/xenc+xml' => array('xenc'),
        'application/xhtml+xml' => array('xhtml', 'xht'),
        'application/xml' => array('xml', 'xsl'),
        'application/xml-dtd' => array('dtd'),
        'application/xop+xml' => array('xop'),
        'application/xproc+xml' => array('xpl'),
        'application/xslt+xml' => array('xslt'),
        'application/xspf+xml' => array('xspf'),
        'application/xv+xml' => array('mxml', 'xhvml', 'xvml', 'xvm'),
        'application/yang' => array('yang'),
        'application/yin+xml' => array('yin'),
        'application/zip' => array('zip'),
        'audio/adpcm' => array('adp'),
        'audio/basic' => array('au', 'snd'),
        'audio/midi' => array('mid', 'midi', 'kar', 'rmi'),
        'audio/mp4' => array('mp4a'),
        'audio/mpeg' => array('mpga', 'mp2', 'mp2a', 'mp3', 'm2a', 'm3a'),
        'audio/ogg' => array('oga', 'ogg', 'spx'),
        'audio/s3m' => array('s3m'),
        'audio/silk' => array('sil'),
        'audio/vnd.dece.audio' => array('uva', 'uvva'),
        'audio/vnd.digital-winds' => array('eol'),
        'audio/vnd.dra' => array('dra'),
        'audio/vnd.dts' => array('dts'),
        'audio/vnd.dts.hd' => array('dtshd'),
        'audio/vnd.lucent.voice' => array('lvp'),
        'audio/vnd.ms-playready.media.pya' => array('pya'),
        'audio/vnd.nuera.ecelp4800' => array('ecelp4800'),
        'audio/vnd.nuera.ecelp7470' => array('ecelp7470'),
        'audio/vnd.nuera.ecelp9600' => array('ecelp9600'),
        'audio/vnd.rip' => array('rip'),
        'audio/webm' => array('weba'),
        'audio/x-aac' => array('aac'),
        'audio/x-aiff' => array('aif', 'aiff', 'aifc'),
        'audio/x-caf' => array('caf'),
        'audio/x-flac' => array('flac'),
        'audio/x-matroska' => array('mka'),
        'audio/x-mpegurl' => array('m3u'),
        'audio/x-ms-wax' => array('wax'),
        'audio/x-ms-wma' => array('wma'),
        'audio/x-pn-realaudio' => array('ram', 'ra'),
        'audio/x-pn-realaudio-plugin' => array('rmp'),
        'audio/x-wav' => array('wav'),
        'audio/xm' => array('xm'),
        'chemical/x-cdx' => array('cdx'),
        'chemical/x-cif' => array('cif'),
        'chemical/x-cmdf' => array('cmdf'),
        'chemical/x-cml' => array('cml'),
        'chemical/x-csml' => array('csml'),
        'chemical/x-xyz' => array('xyz'),
        'image/bmp' => array('bmp'),
        'image/cgm' => array('cgm'),
        'image/g3fax' => array('g3'),
        'image/gif' => array('gif'),
        'image/ief' => array('ief'),
        'image/jpeg' => array('jpeg', 'jpg', 'jpe'),
        'image/ktx' => array('ktx'),
        'image/png' => array('png'),
        'image/prs.btif' => array('btif'),
        'image/sgi' => array('sgi'),
        'image/svg+xml' => array('svg', 'svgz'),
        'image/tiff' => array('tiff', 'tif'),
        'image/vnd.adobe.photoshop' => array('psd'),
        'image/vnd.dece.graphic' => array('uvi', 'uvvi', 'uvg', 'uvvg'),
        'image/vnd.dvb.subtitle' => array('sub'),
        'image/vnd.djvu' => array('djvu', 'djv'),
        'image/vnd.dwg' => array('dwg'),
        'image/vnd.dxf' => array('dxf'),
        'image/vnd.fastbidsheet' => array('fbs'),
        'image/vnd.fpx' => array('fpx'),
        'image/vnd.fst' => array('fst'),
        'image/vnd.fujixerox.edmics-mmr' => array('mmr'),
        'image/vnd.fujixerox.edmics-rlc' => array('rlc'),
        'image/vnd.ms-modi' => array('mdi'),
        'image/vnd.ms-photo' => array('wdp'),
        'image/vnd.net-fpx' => array('npx'),
        'image/vnd.wap.wbmp' => array('wbmp'),
        'image/vnd.xiff' => array('xif'),
        'image/webp' => array('webp'),
        'image/x-3ds' => array('3ds'),
        'image/x-cmu-raster' => array('ras'),
        'image/x-cmx' => array('cmx'),
        'image/x-freehand' => array('fh', 'fhc', 'fh4', 'fh5', 'fh7'),
        'image/x-icon' => array('ico'),
        'image/x-mrsid-image' => array('sid'),
        'image/x-pcx' => array('pcx'),
        'image/x-pict' => array('pic', 'pct'),
        'image/x-portable-anymap' => array('pnm'),
        'image/x-portable-bitmap' => array('pbm'),
        'image/x-portable-graymap' => array('pgm'),
        'image/x-portable-pixmap' => array('ppm'),
        'image/x-rgb' => array('rgb'),
        'image/x-tga' => array('tga'),
        'image/x-xbitmap' => array('xbm'),
        'image/x-xpixmap' => array('xpm'),
        'image/x-xwindowdump' => array('xwd'),
        'message/rfc822' => array('eml', 'mime'),
        'model/iges' => array('igs', 'iges'),
        'model/mesh' => array('msh', 'mesh', 'silo'),
        'model/vnd.collada+xml' => array('dae'),
        'model/vnd.dwf' => array('dwf'),
        'model/vnd.gdl' => array('gdl'),
        'model/vnd.gtw' => array('gtw'),
        'model/vnd.mts' => array('mts'),
        'model/vnd.vtu' => array('vtu'),
        'model/vrml' => array('wrl', 'vrml'),
        'model/x3d+binary' => array('x3db', 'x3dbz'),
        'model/x3d+vrml' => array('x3dv', 'x3dvz'),
        'model/x3d+xml' => array('x3d', 'x3dz'),
        'text/cache-manifest' => array('appcache'),
        'text/calendar' => array('ics', 'ifb'),
        'text/css' => array('css'),
        'text/csv' => array('csv'),
        'text/html' => array('html', 'htm'),
        'text/n3' => array('n3'),
        'text/plain' => array('txt', 'text', 'conf', 'def', 'list', 'log', 'in'),
        'text/prs.lines.tag' => array('dsc'),
        'text/richtext' => array('rtx'),
        'text/sgml' => array('sgml', 'sgm'),
        'text/tab-separated-values' => array('tsv'),
        'text/troff' => array('t', 'tr', 'roff', 'man', 'me', 'ms'),
        'text/turtle' => array('ttl'),
        'text/uri-list' => array('uri', 'uris', 'urls'),
        'text/vcard' => array('vcard'),
        'text/x-asm' => array('s', 'asm'),
        'text/x-c' => array('c', 'cc', 'cxx', 'cpp', 'h', 'hh', 'dic'),
        'text/x-fortran' => array('f', 'for', 'f77', 'f90'),
        'text/x-java-source' => array('java'),
        'text/x-opml' => array('opml'),
        'text/x-pascal' => array('p', 'pas'),
        'text/x-nfo' => array('nfo'),
        'text/x-setext' => array('etx'),
        'text/x-sfv' => array('sfv'),
        'text/x-uuencode' => array('uu'),
        'text/x-vcalendar' => array('vcs'),
        'text/x-vcard' => array('vcf'),
        'video/3gpp' => array('3gp'),
        'video/3gpp2' => array('3g2'),
        'video/h261' => array('h261'),
        'video/h263' => array('h263'),
        'video/h264' => array('h264'),
        'video/jpeg' => array('jpgv'),
        'video/jpm' => array('jpm', 'jpgm'),
        'video/mj2' => array('mj2', 'mjp2'),
        'video/mp4' => array('mp4', 'mp4v', 'mpg4'),
        'video/mpeg' => array('mpeg', 'mpg', 'mpe', 'm1v', 'm2v'),
        'video/ogg' => array('ogv'),
        'video/quicktime' => array('qt', 'mov'),
        'video/vnd.dece.hd' => array('uvh', 'uvvh'),
        'video/vnd.dece.mobile' => array('uvm', 'uvvm'),
        'video/vnd.dece.pd' => array('uvp', 'uvvp'),
        'video/vnd.dece.sd' => array('uvs', 'uvvs'),
        'video/vnd.dece.video' => array('uvv', 'uvvv'),
        'video/vnd.dvb.file' => array('dvb'),
        'video/vnd.fvt' => array('fvt'),
        'video/vnd.mpegurl' => array('mxu', 'm4u'),
        'video/vnd.ms-playready.media.pyv' => array('pyv'),
        'video/vnd.uvvu.mp4' => array('uvu', 'uvvu'),
        'video/vnd.vivo' => array('viv'),
        'video/webm' => array('webm'),
        'video/x-f4v' => array('f4v'),
        'video/x-fli' => array('fli'),
        'video/x-flv' => array('flv'),
        'video/x-m4v' => array('m4v'),
        'video/x-matroska' => array('mkv', 'mk3d', 'mks'),
        'video/x-mng' => array('mng'),
        'video/x-ms-asf' => array('asf', 'asx'),
        'video/x-ms-vob' => array('vob'),
        'video/x-ms-wm' => array('wm'),
        'video/x-ms-wmv' => array('wmv'),
        'video/x-ms-wmx' => array('wmx'),
        'video/x-ms-wvx' => array('wvx'),
        'video/x-msvideo' => array('avi'),
        'video/x-sgi-movie' => array('movie'),
        'video/x-smv' => array('smv'),
    );

    /**
     * {@inheritdoc}
     */
    public function dumpExtensionToType()
    {
        return $this->extensionToType;
    }

    /**
     * {@inheritdoc}
     */
    public function dumpTypeToExtensions()
    {
        return $this->typeToExtensions;
    }

    /**
     * {@inheritdoc}
     */
    public function findExtensions($type)
    {
        if (isset($this->typeToExtensions[$type])) {
            return $this->typeToExtensions[$type];
        }

        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function findType($extension)
    {
        if (isset($this->extensionToType[$extension])) {
            return $this->extensionToType[$extension];
        }

        return null;
    }

    /**
     * UploadsManager constructor.
     *
     */
    public function __construct()
    {
        $this->diskName = 'public';
        $this->access = 'public';
        $this->breadcrumbRootLabel = '/';
        $this->disk = Storage::disk($this->diskName);
    }

    /**
     * Fetch any errors generated by the class when operations have been performed.
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Return files and directories within a folder.
     *
     * @param string $folder
     *
     * @return array of [
     *               'folder' => 'path to current folder',
     *               'folderName' => 'name of just current folder',
     *               'breadCrumbs' => breadcrumb array of [ $path => $foldername ],
     *               'subfolders' => array of [ $path => $foldername] of each subfolder,
     *               'files' => array of file details on each file in folder,
     *               'itemsCount' => a combined count of the files and folders within the current folder
     *               ]
     */
    public function folderInfo($folder = '/')
    {
        $folder = $this->cleanFolder($folder);
        $breadCrumbs = $this->breadcrumbs($folder);

        // Get the names of the sub folders within this folder
        $subFolders = collect($this->disk->directories($folder))->reduce(function ($subFolders, $subFolder) {
            if (!$this->isItemHidden($subFolder)) {
                $subFolders[] = $this->folderDetails($subFolder);
            }

            return $subFolders;
        }, collect([]));

        // Get all files within this folder
        $files = collect($this->disk->files($folder))->reduce(function ($files, $path) {
            if (!$this->isItemHidden($path)) {
                $files[] = $this->fileDetails($path);
            }

            return $files;
        }, collect([]));

        $itemsCount = $subFolders->count() + $files->count();

        return compact('folder', 'folderName', 'breadCrumbs', 'subFolders', 'files', 'itemsCount');
    }

    /**
     * Sanitize the folder name.
     *
     * @param $folder
     *
     * @return string
     */
    protected function cleanFolder($folder)
    {
        return DIRECTORY_SEPARATOR.trim(str_replace('..', '', $folder), DIRECTORY_SEPARATOR);
    }

    /**
     * Return breadcrumbs to current folder.
     *
     * @param $folder
     *
     * @return Collection
     */
    protected function breadcrumbs($folder)
    {
        if ($folder == '/') {
            return ['name' => '/', 'fullPath' => '/'];
        }
        $folder = trim($folder, '/');
        $folders = explode('/', $folder);
        $crumbs = [];
        $path = '';
        foreach ($folders as $folder) {
            $path = $path . '/' . $folder;
            $crumbs[] = ['name' => $folder, 'fullPath' => $path];
        }
        array_unshift($crumbs, ['name' => '/', 'fullPath' => '/']);
        return $crumbs;
    }

    /**
     * Return an array of folder details for a given folder.
     *
     * @param $path
     *
     * @return array
     */
    protected function folderDetails($path)
    {
        $path = '/'.ltrim($path, '/');

        return [
            'name'     => basename($path),
            'mimeType' => 'folder',
            'fullPath' => $path,
            'modified' => $this->fileModified($path),
        ];
    }

    /**
     * Return an array of file details for a given file.
     *
     * @param $path
     *
     * @return array
     */
    protected function fileDetails($path)
    {
        $path = '/'.ltrim($path, '/');

        return [
            'name'         => basename($path),
            'fullPath'     => $path,
            'webPath'      => $this->fileWebpath($path),
            'mimeType'     => $this->fileMimeType($path),
            'size'         => $this->fileSize($path),
            'modified'     => $this->fileModified($path),
            'relativePath' => $this->fileRelativePath($path),
        ];
    }

    /**
     * Return the mime type.
     *
     * @param $path
     *
     * @return string
     */
    public function fileMimeType($path)
    {
        $type = $this->findType(strtolower(pathinfo($path, PATHINFO_EXTENSION)));
        if (!empty($type)) {
            return $type;
        }

        return 'unknown/type';
    }

    /**
     * Return the file size.
     *
     * @param $path
     *
     * @return int
     */
    public function fileSize($path)
    {
        return $this->disk->size($path);
    }

    /**
     * Return the last modified time. If a timestamp can not be found fall back
     * to today's date and time...
     *
     * @param $path
     *
     * @return Carbon
     */
    public function fileModified($path)
    {
        try {
            return Carbon::createFromTimestamp($this->disk->lastModified($path));
        } catch (\Exception $e) {
            return Carbon::now();
        }
    }

    /**
     * Create a new directory.
     *
     * @param $folder
     *
     * @return bool
     */
    public function createDirectory($folder)
    {
        $folder = $this->cleanFolder($folder);
        if ($this->disk->exists($folder)) {
            $this->errors[] = 'Folder "'.$folder.'" already exists.';

            return false;
        }

        return $this->disk->makeDirectory($folder);
    }

    /**
     * Delete a directory.
     *
     * @param $folder
     *
     * @return bool
     */
    public function deleteDirectory($folder)
    {
        $folder = $this->cleanFolder($folder);

        return $this->disk->deleteDirectory($folder);
    }

    /**
     * Delete a file.
     *
     * @param $path
     *
     * @return bool
     */
    public function deleteFile($path)
    {
        $path = $this->cleanFolder($path);
        if (!$this->disk->exists($path)) {
            $this->errors[] = 'File does not exist.';

            return false;
        }

        return $this->disk->delete($path);
    }

    /**
     * @param $path
     * @param $originalFileName
     * @param $newFileName
     *
     * @return bool
     */
    public function rename($path, $originalFileName, $newFileName)
    {
        $path = $this->cleanFolder($path);
        $nameName = $path.DIRECTORY_SEPARATOR.$newFileName;
        if ($this->disk->exists($nameName)) {
            $this->errors[] = 'The file "'.$newFileName.'" already exists in this folder.';

            return false;
        }

        return $this->disk->getDriver()->rename(($path.DIRECTORY_SEPARATOR.$originalFileName), $nameName);
    }

    /**
     * Show all directories that the selected item can be moved to.
     *
     * @return array
     */
    public function allDirectories()
    {
        $directories = $this->disk->allDirectories('/');

	$return = [['name' => '/', 'fullpath' => '/']];
	foreach ($directories as $directory) {
            if (starts_with($directory, '.')) continue;
            $return[] =  ['name' => $directory, 'fullPath' => '/' . $directory];
	}

	logger($return);
	return $return;
    }

    /**
     * @param   $currentFile
     * @param   $newFile
     *
     * @return bool
     */
    public function moveFile($currentFile, $newFile)
    {
        if ($this->disk->exists($newFile)) {
            $this->errors[] = 'File already exists.';

            return false;
        }

        return $this->disk->getDriver()->rename($currentFile, $newFile);
    }

    /**
     * @param $currentFolder
     * @param $newFolder
     *
     * @return bool
     */
    public function moveFolder($currentFolder, $newFolder)
    {
        if ($newFolder == $currentFolder) {
            $this->errors[] = 'Please select another folder to move this folder into.';

            return false;
        }

        if (starts_with($newFolder, $currentFolder)) {
            $this->errors[] = 'You can not move this folder inside of itself.';

            return false;
        }

        return $this->disk->getDriver()->rename($currentFolder, $newFolder);
    }

    /**
     * Return the full web path to a file.
     *
     * @param $path
     *
     * @return string
     */
    public function fileWebpath($path)
    {
        $path = $this->disk->url($path);
        // Remove extra slashes from URL without removing first two slashes after http/https:...
        $path = preg_replace('/([^:])(\/{2,})/', '$1/', $path);

        return $path;
    }

    /**
     * @param $path
     *
     * @return string
     */
    private function fileRelativePath($path)
    {
        $path = $this->fileWebpath($path);
        // @todo This wont work for files not located on the current server...
        $path = str_replace_first(env('APP_URL'), '', $path);
        $path = str_replace(' ', '%20', $path);

        return $path;
    }

    /**
     * This method will take a collection of files that have been
     * uploaded during a request and then save those files to
     * the given path.
     *
     * @param UploadedFilesInterface $files
     * @param string                 $path
     *
     * @return int
     */
    public function saveUploadedFiles(UploadedFile $file, $path = '/')
    {
        if ($this->disk->exists($path.$file->getClientOriginalName())) {
            $this->errors[] = 'File '.$path.$file.' already exists in this folder.';

            return 0;
        }
        if (!$file->storeAs($path, $file->getClientOriginalName(), $this->diskName, $this->access)) {
            $this->errors[] = trans('media-manager::messages.upload_error', ['entity' => $file]);

            return 0;
        }
	return 1;
    }

    /**
     * Work out if an item (file or folder) is hidden (begins with a ".").
     *
     * @param $item
     *
     * @return bool
     */
    private function isItemHidden($item)
    {
        return starts_with(last(explode(DIRECTORY_SEPARATOR, $item)), '.');
    }
}
