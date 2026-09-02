<?php
// ╔══════════════════════════════════════════════════════════╗
// ║         CYBER SEARCHER v3.0 — FULL PRODUCTION (PHP)     ║
// ║              Developer: @DevoIoperTeIegram               ║
// ╚══════════════════════════════════════════════════════════╝

define('BOT_TOKEN',    '7885601619:AAHtJT7LcT9fl2Moy9ZGe7rUps5K_bz6wZA');
define('ADMIN_ID',     8573809926);
define('DB_PATH',      __DIR__ . '/cyber_searcher.db');
define('PREMIUM_PRICE', 100);
define('API_URL',      'https://api.telegram.org/bot' . BOT_TOKEN . '/');
define('BOT_REGISTRY_FILE', __DIR__ . '/bot_registry.json');

// ══════════════════════════════════════════════════════════════
//  MULTI-BOT MANAGEMENT
// ══════════════════════════════════════════════════════════════
function loadRegistry(): array {
    if (!file_exists(BOT_REGISTRY_FILE)) return [];
    $data = @file_get_contents(BOT_REGISTRY_FILE);
    return $data ? (json_decode($data, true) ?? []) : [];
}

function saveRegistry(array $registry): void {
    file_put_contents(BOT_REGISTRY_FILE, json_encode($registry, JSON_PRETTY_PRINT));
}

function spawnBot(string $token, int $ownerID): bool {
    $registry = loadRegistry();
    if (isset($registry[$token])) return false;

    $php = PHP_BINARY;
    $script = escapeshellarg(__FILE__);
    $tok = escapeshellarg($token);
    $own = (int)$ownerID;

    if (PHP_OS_FAMILY === 'Windows') {
        $cmd = "start /B {$php} {$script} --bot {$tok} --owner {$own}";
        pclose(popen($cmd, 'r'));
    } else {
        $cmd = "{$php} {$script} --bot {$tok} --owner {$own} > /dev/null 2>&1 &";
        shell_exec($cmd);
    }

    $registry[$token] = [
        'owner_id' => $ownerID,
        'added'    => date('Y-m-d\TH:i:s'),
    ];
    saveRegistry($registry);
    return true;
}

function killBot(string $token): bool {
    $registry = loadRegistry();
    if (isset($registry[$token])) {
        unset($registry[$token]);
        saveRegistry($registry);
    }
    return true;
}

// ══════════════════════════════════════════════════════════════
//  API LISTS
// ══════════════════════════════════════════════════════════════
$API_LIST = [
    ['name' => 'Wazely API',     'url' => 'https://wazely.vercel.app/api/trlog?site=',              'type' => 'wazely'],
    ['name' => 'Solidar API',    'url' => 'https://solidarksystems.alwaysdata.net/log.php?url=',     'type' => 'solidar'],
    ['name' => 'RootTurkey API', 'url' => 'https://rootturkey.xyz/log?url=',                        'type' => 'rootturkey'],
];

$YASAKLI = ['.gov', '.edu', 'cheatglobal', 'spin', 'bet'];

$TURKIYE_API = [
    'tc'        => ['url' => 'https://ajaxsystems.fun/tc.php?tc={tc}',                             'icon' => '🆔', 'tr' => 'TC Sorgu',       'en' => 'TC Query',         'ar' => 'استعلام TC',       'params' => ['tc']],
    'tcpro'     => ['url' => 'https://ajaxsystems.fun/tcpro.php?tc={tc}',                          'icon' => '🔍', 'tr' => 'TC Pro Sorgu',   'en' => 'TC Pro Query',     'ar' => 'استعلام TC Pro',   'params' => ['tc']],
    'adsoyad'   => ['url' => 'https://ajaxsystems.fun/adsoyad.php?ad={ad}&soyad={soyad}',          'icon' => '👤', 'tr' => 'Ad Soyad',       'en' => 'Name Surname',     'ar' => 'استعلام الاسم',    'params' => ['ad','soyad']],
    'aile'      => ['url' => 'https://ajaxsystems.fun/aile.php?tc={tc}',                           'icon' => '👨‍👩‍👧', 'tr' => 'Aile Sorgu',   'en' => 'Family Query',     'ar' => 'استعلام العائلة',  'params' => ['tc']],
    'ailepro'   => ['url' => 'https://ajaxsystems.fun/ailepro.php?tc={tc}',                        'icon' => '👨‍👩‍👧‍👦', 'tr' => 'Aile Pro',    'en' => 'Family Pro',       'ar' => 'العائلة Pro',      'params' => ['tc']],
    'sulale'    => ['url' => 'https://ajaxsystems.fun/sulale.php?tc={tc}',                         'icon' => '🌳', 'tr' => 'Sülale Sorgu',   'en' => 'Lineage Query',    'ar' => 'استعلام النسب',    'params' => ['tc']],
    'tcgsm'     => ['url' => 'https://ajaxsystems.fun/tcgsm.php?tc={tc}&auth=fire',                'icon' => '📱', 'tr' => 'TC → GSM',       'en' => 'TC to GSM',        'ar' => 'TC إلى GSM',       'params' => ['tc']],
    'gsmtc'     => ['url' => 'https://ajaxsystems.fun/gsmtc.php?gsm={gsm}&auth=fire',              'icon' => '📞', 'tr' => 'GSM → TC',       'en' => 'GSM to TC',        'ar' => 'GSM إلى TC',       'params' => ['gsm']],
    'eokul'     => ['url' => 'https://ajaxsystems.fun/eokul.php?tc={tc}',                          'icon' => '🎓', 'tr' => 'E-Okul Sorgu',   'en' => 'E-School Query',   'ar' => 'استعلام المدرسة',  'params' => ['tc']],
    'tapu'      => ['url' => 'https://ajaxsystems.fun/tapu.php?tc={tc}',                           'icon' => '🏠', 'tr' => 'Tapu Sorgu',     'en' => 'Title Deed Query', 'ar' => 'استعلام الملكية',  'params' => ['tc']],
    'adaparsel' => ['url' => 'https://ajaxsystems.fun/adaparsel.php?il={il}&ilce={ilce}',          'icon' => '🗺️', 'tr' => 'Ada Parsel',      'en' => 'Block Parcel',     'ar' => 'استعلام القطعة',   'params' => ['il','ilce']],
];

$LS_TOKEN = 'NHLpkXyN8Lq3AkkjA5yECyMu5lpA0l0GqnY0Co8kBwh9eIeOJg';
$LS_BASE  = 'https://api.leaksights.com/osint';

function lsUrl(string $endpoint): string {
    global $LS_TOKEN, $LS_BASE;
    return "{$LS_BASE}/{$endpoint}?token={$LS_TOKEN}&text={value}";
}

$LEAKSIGHTS_API = [
    'username'               => ['url' => lsUrl('username'),               'icon' => '👤', 'cat' => 'username', 'tr' => 'Kullanıcı Adı',         'en' => 'Username',          'ar' => 'اسم المستخدم'],
    'username2'              => ['url' => lsUrl('username2'),              'icon' => '🔍', 'cat' => 'username', 'tr' => 'Kullanıcı Adı Detaylı', 'en' => 'Username Detailed', 'ar' => 'اسم المستخدم تفصيلي'],
    'fullnamebreach'         => ['url' => lsUrl('fullnamebreach'),         'icon' => '📝', 'cat' => 'name',     'tr' => 'Tam İsim',              'en' => 'Full Name',         'ar' => 'الاسم الكامل'],
    'nome'                   => ['url' => lsUrl('nome'),                   'icon' => '👤', 'cat' => 'name',     'tr' => 'İsim',                  'en' => 'Name',              'ar' => 'الاسم'],
    'nomepai'                => ['url' => lsUrl('nomepai'),                'icon' => '👨', 'cat' => 'name',     'tr' => 'Baba Adı',              'en' => 'Father Name',       'ar' => 'اسم الأب'],
    'nomemae'                => ['url' => lsUrl('nomemae'),                'icon' => '👩', 'cat' => 'name',     'tr' => 'Anne Adı',              'en' => 'Mother Name',       'ar' => 'اسم الأم'],
    'email'                  => ['url' => lsUrl('email'),                  'icon' => '📧', 'cat' => 'contact',  'tr' => 'E-posta',               'en' => 'Email',             'ar' => 'البريد الإلكتروني'],
    'number'                 => ['url' => lsUrl('number'),                 'icon' => '📱', 'cat' => 'contact',  'tr' => 'Telefon',               'en' => 'Phone',             'ar' => 'الهاتف'],
    'telefone'               => ['url' => lsUrl('telefone'),               'icon' => '📞', 'cat' => 'contact',  'tr' => 'Telefon Detaylı',       'en' => 'Phone Detailed',    'ar' => 'الهاتف التفصيلي'],
    'telefone_basic'         => ['url' => lsUrl('telefone_basic'),         'icon' => '📱', 'cat' => 'contact',  'tr' => 'Telefon Temel',         'en' => 'Phone Basic',       'ar' => 'الهاتف الأساسي'],
    'ip'                     => ['url' => lsUrl('ip'),                     'icon' => '🌐', 'cat' => 'ip',       'tr' => 'IP Sızıntı',            'en' => 'IP Leak',           'ar' => 'تسريب IP'],
    'ipgeo'                  => ['url' => lsUrl('ipgeo'),                  'icon' => '📍', 'cat' => 'ip',       'tr' => 'IP Konum',              'en' => 'IP Location',       'ar' => 'موقع IP'],
    'hwid'                   => ['url' => lsUrl('hwid'),                   'icon' => '💻', 'cat' => 'ip',       'tr' => 'HWID',                  'en' => 'HWID',              'ar' => 'HWID'],
    'proxydetect'            => ['url' => lsUrl('proxydetect'),            'icon' => '🛡️', 'cat' => 'ip',       'tr' => 'Proxy Tespit',          'en' => 'Proxy Detection',   'ar' => 'كشف البروكسي'],
    'portscam'               => ['url' => lsUrl('portscam'),               'icon' => '🔌', 'cat' => 'ip',       'tr' => 'Port Tarama',           'en' => 'Port Scan',         'ar' => 'فحص المنافذ'],
    'subnet'                 => ['url' => lsUrl('subnet'),                 'icon' => '🌐', 'cat' => 'ip',       'tr' => 'Subnet',                'en' => 'Subnet',            'ar' => 'الشبكة الفرعية'],
    'domainmapper'           => ['url' => lsUrl('domainmapper'),           'icon' => '🗺️', 'cat' => 'domain',   'tr' => 'Domain Haritalama',     'en' => 'Domain Mapping',    'ar' => 'رسم خريطة النطاق'],
    'subdomainsearch'        => ['url' => lsUrl('subdomainsearch'),        'icon' => '🔍', 'cat' => 'domain',   'tr' => 'Subdomain Arama',       'en' => 'Subdomain Search',  'ar' => 'بحث النطاق الفرعي'],
    'subdmains'              => ['url' => lsUrl('subdmains'),              'icon' => '🌐', 'cat' => 'domain',   'tr' => 'Subdomain Detaylı',     'en' => 'Subdomain Detailed','ar' => 'النطاق الفرعي التفصيلي'],
    'url'                    => ['url' => lsUrl('url'),                    'icon' => '🔗', 'cat' => 'url',      'tr' => 'URL Sızıntı',           'en' => 'URL Leak',          'ar' => 'تسريب URL'],
    'url2'                   => ['url' => lsUrl('url2'),                   'icon' => '🔗', 'cat' => 'url',      'tr' => 'URL Detaylı',           'en' => 'URL Detailed',      'ar' => 'URL التفصيلي'],
    'search_url_all_database'=> ['url' => lsUrl('search_url_all_database'),'icon' => '🔎', 'cat' => 'url',      'tr' => 'URL Tüm Veritabanı',    'en' => 'URL All Database',  'ar' => 'URL جميع قواعد البيانات'],
    'passport'               => ['url' => lsUrl('passport'),               'icon' => '🛂', 'cat' => 'identity', 'tr' => 'Pasaport',              'en' => 'Passport',          'ar' => 'جواز السفر'],
    'cpf'                    => ['url' => lsUrl('cpf'),                    'icon' => '🆔', 'cat' => 'identity', 'tr' => 'CPF',                   'en' => 'CPF',               'ar' => 'CPF'],
    'dni'                    => ['url' => lsUrl('dni'),                    'icon' => '🆔', 'cat' => 'identity', 'tr' => 'DNI',                   'en' => 'DNI',               'ar' => 'DNI'],
    'ssn'                    => ['url' => lsUrl('ssn'),                    'icon' => '🆔', 'cat' => 'identity', 'tr' => 'SSN',                   'en' => 'SSN',               'ar' => 'SSN'],
    'parentescpf'            => ['url' => lsUrl('parentescpf'),            'icon' => '👨‍👩‍👧‍👦', 'cat' => 'identity', 'tr' => 'Akraba CPF',   'en' => 'Relative CPF',      'ar' => 'CPF الأقارب'],
    'password'               => ['url' => lsUrl('password'),               'icon' => '🔑', 'cat' => 'other',    'tr' => 'Şifre',                 'en' => 'Password',          'ar' => 'كلمة المرور'],
    'facebookid'             => ['url' => lsUrl('facebookid'),             'icon' => '📘', 'cat' => 'other',    'tr' => 'Facebook ID',           'en' => 'Facebook ID',       'ar' => 'Facebook ID'],
    'placa'                  => ['url' => lsUrl('placa'),                  'icon' => '🚗', 'cat' => 'other',    'tr' => 'Plaka (LS)',             'en' => 'License Plate (LS)','ar' => 'لوحة السيارة (LS)'],
];

$LEAKSIGHTS_CATS = [
    'username' => ['tr' => '👤 KULLANICI ADI',  'en' => '👤 USERNAME',     'ar' => '👤 اسم المستخدم'],
    'name'     => ['tr' => '📝 İSİM SORGULARI', 'en' => '📝 NAME QUERIES', 'ar' => '📝 استعلامات الاسم'],
    'contact'  => ['tr' => '📱 İLETİŞİM',        'en' => '📱 CONTACT',      'ar' => '📱 الاتصال'],
    'ip'       => ['tr' => '🌐 IP / AĞ',         'en' => '🌐 IP / NETWORK', 'ar' => '🌐 IP / الشبكة'],
    'domain'   => ['tr' => '🗺️ DOMAIN',           'en' => '🗺️ DOMAIN',       'ar' => '🗺️ النطاق'],
    'url'      => ['tr' => '🔗 URL',              'en' => '🔗 URL',          'ar' => '🔗 URL'],
    'identity' => ['tr' => '🛂 KİMLİK',           'en' => '🛂 IDENTITY',     'ar' => '🛂 الهوية'],
    'other'    => ['tr' => '🔧 DİĞER',            'en' => '🔧 OTHER',        'ar' => '🔧 أخرى'],
];

$TOOLS_API = [
    'bedrock'   => 'https://wazelyapi.vercel.app/api/bedrock?adres=',
    'ccgen'     => 'https://wazelyapi.vercel.app/api/ccgen?bin=',
    'dctoken'   => 'https://wazelyapi.vercel.app/api/dcbottokencheck?token=',
    'tgtoken'   => 'https://wazelyapi.vercel.app/api/tgtokencheck?token=',
    'eczane'    => 'https://wazely.vercel.app/api/eczane?ad=',
    'ipinfo'    => 'https://wazely.vercel.app/api/ipinfo?ip=',
    'dns'       => 'https://wazely.vercel.app/api/dns?domain=',
    'bahis'     => 'https://wazely.vercel.app/api/bahis?isimsoyisim=',
    'plaka'     => 'https://wazely.vercel.app/api/plaka?plate=',
    'predunyam' => 'https://wazely.vercel.app/api/predunyam',
];

$TOOL_PROMPTS = [
    'tr' => [
        'bedrock'   => '🎮 IP:PORT girin (Örn: bee.mc-complex.com:19132)',
        'ccgen'     => '💳 BIN girin (Örn: 450000)',
        'dctoken'   => '🤖 Discord Bot Token girin:',
        'tgtoken'   => '✈️ Telegram Bot Token girin:',
        'eczane'    => '💊 Eczane adını girin:',
        'ipinfo'    => '🌐 IP Adresini girin:',
        'dns'       => '🔎 Domain girin (Örn: google.com):',
        'bahis'     => '⚽ İsim Soyisim girin:',
        'plaka'     => '🚗 Plaka girin (Örn: 34ABC123):',
        'proxycheck'=> '🛡️ IP adresini girin (Örn: 8.8.8.8):',
        'urlscan'   => '🔍 Domain girin (Örn: google.com):',
        'addbot'    => "🤖 Bot Token'ını girin:\n\nÖrnek: 8369544888:ABC123...",
    ],
    'en' => [
        'bedrock'   => '🎮 Enter IP:PORT (e.g., bee.mc-complex.com:19132)',
        'ccgen'     => '💳 Enter BIN (e.g., 450000)',
        'dctoken'   => '🤖 Enter Discord Bot Token:',
        'tgtoken'   => '✈️ Enter Telegram Bot Token:',
        'eczane'    => '💊 Enter pharmacy name:',
        'ipinfo'    => '🌐 Enter IP address:',
        'dns'       => '🔎 Enter domain (e.g., google.com):',
        'bahis'     => '⚽ Enter full name:',
        'plaka'     => '🚗 Enter plate (e.g., 34ABC123):',
        'proxycheck'=> '🛡️ Enter IP address (e.g., 8.8.8.8):',
        'urlscan'   => '🔍 Enter domain (e.g., google.com):',
        'addbot'    => "🤖 Enter Bot Token:\n\nExample: 8369544888:ABC123...",
    ],
    'ar' => [
        'bedrock'   => '🎮 أدخل IP:PORT',
        'ccgen'     => '💳 أدخل BIN',
        'dctoken'   => '🤖 أدخل Discord Bot Token:',
        'tgtoken'   => '✈️ أدخل Telegram Bot Token:',
        'eczane'    => '💊 أدخل اسم الصيدلية:',
        'ipinfo'    => '🌐 أدخل عنوان IP:',
        'dns'       => '🔎 أدخل النطاق:',
        'bahis'     => '⚽ أدخل الاسم الكامل:',
        'plaka'     => '🚗 أدخل رقم اللوحة:',
        'proxycheck'=> '🛡️ أدخل عنوان IP:',
        'urlscan'   => '🔍 أدخل النطاق:',
        'addbot'    => '🤖 أدخل توكن البوت:',
    ],
];

$TURKEY_PROMPTS = [
    'tr' => [
        'tc'        => '🆔 TC Kimlik Numarası girin (11 haneli):',
        'tcpro'     => '🔍 TC Kimlik Numarası girin (11 haneli):',
        'adsoyad'   => '👤 Ad Soyad girin (Örn: Ali Yılmaz):',
        'aile'      => '👨‍👩‍👧 TC Kimlik Numarası girin (11 haneli):',
        'ailepro'   => '👨‍👩‍👧‍👦 TC Kimlik Numarası girin (11 haneli):',
        'sulale'    => '🌳 TC Kimlik Numarası girin (11 haneli):',
        'tcgsm'     => '📱 TC Kimlik Numarası girin (11 haneli):',
        'gsmtc'     => '📞 GSM numarası girin (Örn: 5306524123):',
        'eokul'     => '🎓 TC Kimlik Numarası girin (11 haneli):',
        'tapu'      => '🏠 TC Kimlik Numarası girin (11 haneli):',
        'adaparsel' => '🗺️ İl,İlçe girin (Örn: İSTANBUL,KADIKÖY):',
    ],
    'en' => [
        'tc'        => '🆔 Enter TC ID number (11 digits):',
        'tcpro'     => '🔍 Enter TC ID number (11 digits):',
        'adsoyad'   => '👤 Enter name surname (e.g., Ali Yılmaz):',
        'aile'      => '👨‍👩‍👧 Enter TC ID number (11 digits):',
        'ailepro'   => '👨‍👩‍👧‍👦 Enter TC ID number (11 digits):',
        'sulale'    => '🌳 Enter TC ID number (11 digits):',
        'tcgsm'     => '📱 Enter TC ID number (11 digits):',
        'gsmtc'     => '📞 Enter GSM number (e.g., 5306524123):',
        'eokul'     => '🎓 Enter TC ID number (11 digits):',
        'tapu'      => '🏠 Enter TC ID number (11 digits):',
        'adaparsel' => '🗺️ Enter Province,District (e.g., ISTANBUL,KADIKOY):',
    ],
    'ar' => [
        'tc'        => '🆔 أدخل رقم الهوية (11 رقم):',
        'tcpro'     => '🔍 أدخل رقم الهوية (11 رقم):',
        'adsoyad'   => '👤 أدخل الاسم واللقب:',
        'aile'      => '👨‍👩‍👧 أدخل رقم الهوية (11 رقم):',
        'ailepro'   => '👨‍👩‍👧‍👦 أدخل رقم الهوية (11 رقم):',
        'sulale'    => '🌳 أدخل رقم الهوية (11 رقم):',
        'tcgsm'     => '📱 أدخل رقم الهوية (11 رقم):',
        'gsmtc'     => '📞 أدخل رقم GSM:',
        'eokul'     => '🎓 أدخل رقم الهوية (11 رقم):',
        'tapu'      => '🏠 أدخل رقم الهوية (11 رقم):',
        'adaparsel' => '🗺️ أدخل المحافظة,المنطقة:',
    ],
];

// ══════════════════════════════════════════════════════════════
//  STRINGS
// ══════════════════════════════════════════════════════════════
$S = [
    'tr' => [
        'welcome'          => "🌟 <b>Cyber Searcher</b>\n\nHoşgeldin, <b>{name}</b>!\n📌 Durum: {status}\n\n🔻 Aşağıdan işlem seç:",
        'premium_on'       => '⭐ PREMIUM',
        'free'             => '🆓 Ücretsiz',
        'select_op'        => '🛠 Kullanmak istediğin aracı seç:',
        'combo_ask'        => '🌐 Domain gir (Örn: netflix.com) veya (netflix.com 100):',
        'searching'        => '🔍 <b>{domain}</b> taranıyor...',
        'no_result'        => '❌ {domain} için sonuç bulunamadı.',
        'combo_caption'    => '✅ <b>{domain}</b> | <b>{count}</b> Hesap\nAPI: {apis}',
        'stats_title'      => '📊 <b>İSTATİSTİKLERİN</b>',
        'profile_title'    => '👤 <b>PROFİL</b>',
        'lb_title'         => '🏆 <b>LİDER TABLOSU</b>',
        'help_title'       => '📖 <b>YARDIM MENÜSÜ</b>',
        'no_stats'         => '📊 Henüz hiç sorgu yapmadınız!',
        'api_title'        => "⚙️ <b>API DEĞİŞTİR</b>\n\n📌 Mevcut: <b>{cur}</b>\n\nBir API seç:",
        'api_set'          => '✅ API → <b>{api}</b>',
        'lang_pick'        => '🌍 Dil seçin / Select language / اختر لغتك',
        'lang_ok'          => '✅ Dil seçildi!',
        'premium_title'    => '⭐ <b>PREMIUM ÜYELİK</b>',
        'premium_price_txt'=> '💰 Fiyat: <b>100 Telegram Yıldızı</b>',
        'premium_dur'      => '♾️ Süre: <b>Sınırsız (Ömür Boyu)</b>',
        'premium_features' => "🎯 <b>30+ OSINT Sorgusu:</b>\n   👤 Kullanıcı Adı Sızıntı\n   📧 E-posta Sızıntı\n   📱 Telefon Sızıntı\n   🌐 IP Sızıntı + Konum\n   🛡️ Proxy Tespit + Port Tarama\n   🗺️ Domain Haritalama\n   🔗 URL Sızıntı\n   🛂 Pasaport, CPF, DNI, SSN\n   🔑 Şifre Sızıntı\n   📘 Facebook ID + Plaka",
        'already_premium'  => '⭐ Zaten Premium üyesiniz!',
        'prem_ok'          => '🎉 <b>Premium aktif!</b>',
        'buy_btn'          => '⭐ Premium Satın Al',
        'back_btn'         => '◀️ Geri',
        'home_btn'         => '🏠 Ana Menü',
        'tools_btn'        => '🛠 Araçlar',
        'premium_req'      => '🔒 Bu özellik Premium!',
        'video_ask'        => '🎥 Video linkini gönder:',
        'video_wait'       => '⏳ İndiriliyor...',
        'video_err'        => "❌ İndirilemedi:\n<code>{err}</code>",
        'video_caption'    => '🎥 <b>{title}</b>\n📦 {size}  ⏱ {dur}s  👤 {upl}',
        'invalid_link'     => '❌ Geçerli bir link gir!',
        'ls_ask'           => "{icon} <b>LeakSights — {tool}</b>\n\n📥 Sorgu değerini gir:",
        'ls_caption'       => "📋 LeakSights ⭐\n🔍 Aranan: <code>{val}</code>\n📅 {date}",
        'tr_ask'           => "{prompt}\n\n📌 Sonuç TXT olarak gelir.",
        'tr_caption'       => "📋 {tool} Sorgu\n🔍 Param: <code>{param}</code>\n📅 {date}",
        'processing'       => '🔄 Sorgulanıyor...',
        'admin_only'       => '❌ Bu komut sadece admin içindir!',
        'no_data'          => '❌ Veri alınamadı.',
        'given_ok'         => '✅ Premium verildi: @{user}',
        'removed_ok'       => '✅ Premium kaldırıldı: @{user}',
        'user_nf'          => '❌ Kullanıcı bulunamadı!',
        'enter_val'        => 'Değeri gir:',
        'invalid_tc'       => '❌ Geçersiz TC (11 haneli sayı olmalı)!',
        'invalid_gsm'      => '❌ Geçersiz GSM (10 haneli)!',
        'invalid_adsoyad'  => '❌ Ad ve Soyad gir!',
        'invalid_adaparsel'=> '❌ İl,İlçe formatında gir!',
        'multi_bot_list'   => '🤖 <b>BOT LİSTESİ</b>',
        'multi_bot_running'=> '🟢 Çalışıyor',
        'multi_bot_stopped'=> '🔴 Durduruldu',
        'multi_bot_total'  => '📊 Toplam: {count} bot',
        'multi_bot_added'  => "✅ Bot başlatıldı!\n\n🔑 Token: `{token}`\n👤 Sahip: {owner}\n📌 Durum: 🟢 Çalışıyor",
        'multi_bot_removed'=> "✅ Bot durduruldu!\n\n🔑 Token: `{token}`",
        'multi_bot_not_found' => '❌ Token `{token}` bulunamadı!',
        'multi_bot_exists' => '⚠️ Bu token zaten çalışıyor!',
        'multi_bot_no_bots'=> '📭 Hiç bot kaydı bulunamadı.',
        'multi_bot_add_usage' => "❌ Kullanım: /addbot BOT_TOKEN\n\nÖrnek: /addbot 8369544888:ABC123...",
        'announce_title'   => '📢 <b>ADMIN DUYURU</b>',
        'announce_sent'    => '✅ Duyuru gönderildi!',
        'announce_usage'   => '❌ Kullanım: /duyuru MESAJ',
        'announce_no_users'=> '❌ Gönderilecek kullanıcı bulunamadı.',
    ],
    'en' => [
        'welcome'          => "🌟 <b>Cyber Searcher v3.0</b>\n\nWelcome, <b>{name}</b>!\n📌 Status: {status}\n\n🔻 Select an option:",
        'premium_on'       => '⭐ PREMIUM',
        'free'             => '🆓 Free',
        'select_op'        => '🛠 Select a tool:',
        'combo_ask'        => '🌐 Enter domain (e.g., netflix.com) or (netflix.com 100):',
        'searching'        => '🔍 Scanning <b>{domain}</b>...',
        'no_result'        => '❌ No results for {domain}.',
        'combo_caption'    => '✅ <b>{domain}</b> | <b>{count}</b> Accounts\nAPI: {apis}',
        'stats_title'      => '📊 <b>YOUR STATISTICS</b>',
        'profile_title'    => '👤 <b>PROFILE</b>',
        'lb_title'         => '🏆 <b>LEADERBOARD</b>',
        'help_title'       => '📖 <b>HELP MENU</b>',
        'no_stats'         => '📊 No queries yet!',
        'api_title'        => "⚙️ <b>CHANGE API</b>\n\n📌 Current: <b>{cur}</b>\n\nSelect an API:",
        'api_set'          => '✅ API → <b>{api}</b>',
        'lang_pick'        => '🌍 Dil seçin / Select language / اختر لغتك',
        'lang_ok'          => '✅ Language selected!',
        'premium_title'    => '⭐ <b>PREMIUM MEMBERSHIP</b>',
        'premium_price_txt'=> '💰 Price: <b>100 Telegram Stars</b>',
        'premium_dur'      => '♾️ Duration: <b>Unlimited (Lifetime)</b>',
        'premium_features' => "🎯 <b>30+ OSINT Queries</b>",
        'already_premium'  => '⭐ You are already Premium!',
        'prem_ok'          => '🎉 <b>Premium activated!</b>',
        'buy_btn'          => '⭐ Buy Premium',
        'back_btn'         => '◀️ Back',
        'home_btn'         => '🏠 Main Menu',
        'tools_btn'        => '🛠 Tools',
        'premium_req'      => '🔒 Premium required!',
        'video_ask'        => '🎥 Send video link:',
        'video_wait'       => '⏳ Downloading...',
        'video_err'        => "❌ Download failed:\n<code>{err}</code>",
        'video_caption'    => '🎥 <b>{title}</b>\n📦 {size}  ⏱ {dur}s  👤 {upl}',
        'invalid_link'     => '❌ Please send a valid link!',
        'ls_ask'           => "{icon} <b>LeakSights — {tool}</b>\n\n📥 Enter query value:",
        'ls_caption'       => "📋 LeakSights ⭐\n🔍 Searched: <code>{val}</code>\n📅 {date}",
        'tr_ask'           => "{prompt}\n\n📌 Result sent as TXT.",
        'tr_caption'       => "📋 {tool} Query\n🔍 Param: <code>{param}</code>\n📅 {date}",
        'processing'       => '🔄 Processing...',
        'admin_only'       => '❌ Admin only!',
        'no_data'          => '❌ No data received.',
        'given_ok'         => '✅ Premium granted: @{user}',
        'removed_ok'       => '✅ Premium removed: @{user}',
        'user_nf'          => '❌ User not found!',
        'enter_val'        => 'Enter value:',
        'invalid_tc'       => '❌ Invalid TC (11-digit number required)!',
        'invalid_gsm'      => '❌ Invalid GSM (10 digits)!',
        'invalid_adsoyad'  => '❌ Enter name and surname!',
        'invalid_adaparsel'=> '❌ Enter Province,District format!',
        'multi_bot_list'   => '🤖 <b>BOT LIST</b>',
        'multi_bot_running'=> '🟢 Running',
        'multi_bot_stopped'=> '🔴 Stopped',
        'multi_bot_total'  => '📊 Total: {count} bots',
        'multi_bot_added'  => "✅ Bot started!\n\n🔑 Token: `{token}`\n👤 Owner: {owner}\n📌 Status: 🟢 Running",
        'multi_bot_removed'=> "✅ Bot stopped!\n\n🔑 Token: `{token}`",
        'multi_bot_not_found' => '❌ Token `{token}` not found!',
        'multi_bot_exists' => '⚠️ This token is already running!',
        'multi_bot_no_bots'=> '📭 No bot registrations found.',
        'multi_bot_add_usage' => "❌ Usage: /addbot BOT_TOKEN\n\nExample: /addbot 8369544888:ABC123...",
        'announce_title'   => '📢 <b>ADMIN ANNOUNCEMENT</b>',
        'announce_sent'    => '✅ Announcement sent!',
        'announce_usage'   => '❌ Usage: /announce MESSAGE',
        'announce_no_users'=> '❌ No users found to send.',
    ],
    'ar' => [
        'welcome'          => "🌟 <b>Cyber Searcher</b>\n\nمرحباً، <b>{name}</b>!\n📌 الحالة: {status}\n\n🔻 اختر خياراً:",
        'premium_on'       => '⭐ بريميوم',
        'free'             => '🆓 مجاني',
        'select_op'        => '🛠 اختر أداة:',
        'combo_ask'        => '🌐 أدخل النطاق (مثال: netflix.com):',
        'searching'        => '🔍 جاري فحص <b>{domain}</b>...',
        'no_result'        => '❌ لا نتائج لـ {domain}.',
        'combo_caption'    => '✅ <b>{domain}</b> | <b>{count}</b> حساب\nAPI: {apis}',
        'stats_title'      => '📊 <b>إحصائياتك</b>',
        'profile_title'    => '👤 <b>الملف الشخصي</b>',
        'lb_title'         => '🏆 <b>لوحة المتصدرين</b>',
        'help_title'       => '📖 <b>قائمة المساعدة</b>',
        'no_stats'         => '📊 لم تقم بأي استعلام بعد!',
        'api_title'        => "⚙️ <b>تغيير API</b>\n\n📌 الحالي: <b>{cur}</b>\n\nاختر API:",
        'api_set'          => '✅ API → <b>{api}</b>',
        'lang_pick'        => '🌍 Dil seçin / Select language / اختر لغتك',
        'lang_ok'          => '✅ تم اختيار اللغة!',
        'premium_title'    => '⭐ <b>عضوية بريميوم</b>',
        'premium_price_txt'=> '💰 السعر: <b>100 نجمة تيليجرام</b>',
        'premium_dur'      => '♾️ المدة: <b>غير محدودة</b>',
        'premium_features' => '🎯 <b>30+ استعلام OSINT</b>',
        'already_premium'  => '⭐ أنت بالفعل بريميوم!',
        'prem_ok'          => '🎉 <b>تم تفعيل البريميوم!</b>',
        'buy_btn'          => '⭐ شراء بريميوم',
        'back_btn'         => '◀️ رجوع',
        'home_btn'         => '🏠 القائمة الرئيسية',
        'tools_btn'        => '🛠 الأدوات',
        'premium_req'      => '🔒 مطلوب بريميوم!',
        'video_ask'        => '🎥 أرسل رابط الفيديو:',
        'video_wait'       => '⏳ جاري التحميل...',
        'video_err'        => "❌ فشل التحميل:\n<code>{err}</code>",
        'video_caption'    => '🎥 <b>{title}</b>\n📦 {size}  ⏱ {dur}s  👤 {upl}',
        'invalid_link'     => '❌ أرسل رابطاً صحيحاً!',
        'ls_ask'           => "{icon} <b>LeakSights — {tool}</b>\n\n📥 أدخل قيمة البحث:",
        'ls_caption'       => "📋 LeakSights ⭐\n🔍 بحث: <code>{val}</code>\n📅 {date}",
        'tr_ask'           => "{prompt}\n\n📌 سيتم إرسال النتيجة كـ TXT.",
        'tr_caption'       => "📋 استعلام {tool}\n🔍 المعامل: <code>{param}</code>\n📅 {date}",
        'processing'       => '🔄 جاري المعالجة...',
        'admin_only'       => '❌ للمسؤول فقط!',
        'no_data'          => '❌ لا توجد بيانات.',
        'given_ok'         => '✅ تم منح البريميوم: @{user}',
        'removed_ok'       => '✅ تم إلغاء البريميوم: @{user}',
        'user_nf'          => '❌ المستخدم غير موجود!',
        'enter_val'        => 'أدخل القيمة:',
        'invalid_tc'       => '❌ رقم هوية غير صحيح!',
        'invalid_gsm'      => '❌ رقم GSM غير صحيح!',
        'invalid_adsoyad'  => '❌ أدخل الاسم الكامل!',
        'invalid_adaparsel'=> '❌ أدخل المحافظة,المنطقة!',
        'multi_bot_list'   => '🤖 <b>قائمة البوتات</b>',
        'multi_bot_running'=> '🟢 يعمل',
        'multi_bot_stopped'=> '🔴 متوقف',
        'multi_bot_total'  => '📊 المجموع: {count} بوت',
        'multi_bot_added'  => "✅ تم تشغيل البوت!\n\n🔑 التوكن: `{token}`\n👤 المالك: {owner}\n📌 الحالة: 🟢 يعمل",
        'multi_bot_removed'=> "✅ تم إيقاف البوت!\n\n🔑 التوكن: `{token}`",
        'multi_bot_not_found' => '❌ التوكن `{token}` غير موجود!',
        'multi_bot_exists' => '⚠️ هذا التوكن يعمل بالفعل!',
        'multi_bot_no_bots'=> '📭 لا توجد بوتات مسجلة.',
        'multi_bot_add_usage' => '❌ الاستخدام: /addbot BOT_TOKEN',
        'announce_title'   => '📢 <b>إعلان من المدير</b>',
        'announce_sent'    => '✅ تم إرسال الإعلان!',
        'announce_usage'   => '❌ الاستخدام: /duyuru الرسالة',
        'announce_no_users'=> '❌ لا يوجد مستخدمين للإرسال.',
    ],
];

// ══════════════════════════════════════════════════════════════
//  DATABASE FUNCTIONS
// ══════════════════════════════════════════════════════════════
function dbConn(): SQLite3 {
    $db = new SQLite3(DB_PATH);
    $db->exec("PRAGMA journal_mode=WAL;");
    return $db;
}

function dbInit(): void {
    $db = dbConn();
    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            user_id       INTEGER PRIMARY KEY,
            username      TEXT    DEFAULT '',
            first_name    TEXT    DEFAULT '',
            join_date     TEXT    DEFAULT '',
            total_checks  INTEGER DEFAULT 0,
            total_combos  INTEGER DEFAULT 0,
            is_premium    INTEGER DEFAULT 0,
            premium_date  TEXT    DEFAULT '',
            language      TEXT    DEFAULT 'tr',
            api_pref      INTEGER DEFAULT 0
        );
        CREATE TABLE IF NOT EXISTS premium_logs (
            id        INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id   INTEGER,
            username  TEXT,
            amount    INTEGER,
            date      TEXT
        );
        CREATE TABLE IF NOT EXISTS next_steps (
            user_id   INTEGER PRIMARY KEY,
            step      TEXT,
            extra     TEXT,
            ts        INTEGER DEFAULT 0
        );
    ");
    $db->close();
}

dbInit();

function dbGet(int $userId, string $col): mixed {
    $db = dbConn();
    $stmt = $db->prepare("SELECT {$col} FROM users WHERE user_id = :uid");
    $stmt->bindValue(':uid', $userId, SQLITE3_INTEGER);
    $res = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
    $db->close();
    return $res ? $res[$col] : null;
}

function dbSet(int $userId, string $col, mixed $val): void {
    $db = dbConn();
    $stmt = $db->prepare("UPDATE users SET {$col} = :val WHERE user_id = :uid");
    $stmt->bindValue(':val', $val);
    $stmt->bindValue(':uid', $userId, SQLITE3_INTEGER);
    $stmt->execute();
    $db->close();
}

function addUser(int $userId, string $username = '', string $firstName = ''): void {
    $db = dbConn();
    $stmt = $db->prepare("INSERT OR IGNORE INTO users (user_id,username,first_name,join_date) VALUES (:uid,:un,:fn,:jd)");
    $stmt->bindValue(':uid', $userId, SQLITE3_INTEGER);
    $stmt->bindValue(':un', $username);
    $stmt->bindValue(':fn', $firstName);
    $stmt->bindValue(':jd', date('Y-m-d H:i'));
    $stmt->execute();
    $db->close();
}

function updateStats(int $userId, int $combos): void {
    $db = dbConn();
    $stmt = $db->prepare("UPDATE users SET total_checks=total_checks+1, total_combos=total_combos+:c WHERE user_id=:uid");
    $stmt->bindValue(':c', $combos, SQLITE3_INTEGER);
    $stmt->bindValue(':uid', $userId, SQLITE3_INTEGER);
    $stmt->execute();
    $db->close();
}

function isPremium(int $userId): bool {
    return dbGet($userId, 'is_premium') == 1;
}

function setPremium(int $userId, string $username = ''): void {
    $db = dbConn();
    $now = date('Y-m-d H:i:s');
    $stmt = $db->prepare("UPDATE users SET is_premium=1, premium_date=:nd WHERE user_id=:uid");
    $stmt->bindValue(':nd', $now);
    $stmt->bindValue(':uid', $userId, SQLITE3_INTEGER);
    $stmt->execute();
    $stmt2 = $db->prepare("INSERT INTO premium_logs (user_id,username,amount,date) VALUES (:uid,:un,:amt,:dt)");
    $stmt2->bindValue(':uid', $userId, SQLITE3_INTEGER);
    $stmt2->bindValue(':un', $username);
    $stmt2->bindValue(':amt', PREMIUM_PRICE, SQLITE3_INTEGER);
    $stmt2->bindValue(':dt', $now);
    $stmt2->execute();
    $db->close();
}

function removePremium(int $userId): void {
    dbSet($userId, 'is_premium', 0);
    dbSet($userId, 'premium_date', '');
}

function getUserStats(int $userId): ?array {
    $db = dbConn();
    $stmt = $db->prepare("SELECT total_checks,total_combos,join_date,is_premium,premium_date,username,first_name FROM users WHERE user_id=:uid");
    $stmt->bindValue(':uid', $userId, SQLITE3_INTEGER);
    $r = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
    $db->close();
    return $r ?: null;
}

function getLeaderboard(int $limit = 10): array {
    $db = dbConn();
    $stmt = $db->prepare("SELECT user_id,username,first_name,total_checks,total_combos,is_premium FROM users ORDER BY total_combos DESC LIMIT :lim");
    $stmt->bindValue(':lim', $limit, SQLITE3_INTEGER);
    $res = $stmt->execute();
    $rows = [];
    while ($r = $res->fetchArray(SQLITE3_ASSOC)) $rows[] = $r;
    $db->close();
    return $rows;
}

function getPremiumUsers(): array {
    $db = dbConn();
    $res = $db->query("SELECT user_id,username,first_name,premium_date FROM users WHERE is_premium=1");
    $rows = [];
    while ($r = $res->fetchArray(SQLITE3_ASSOC)) $rows[] = $r;
    $db->close();
    return $rows;
}

function getPremiumLogs(int $limit = 20): array {
    $db = dbConn();
    $stmt = $db->prepare("SELECT user_id,username,amount,date FROM premium_logs ORDER BY date DESC LIMIT :lim");
    $stmt->bindValue(':lim', $limit, SQLITE3_INTEGER);
    $res = $stmt->execute();
    $rows = [];
    while ($r = $res->fetchArray(SQLITE3_ASSOC)) $rows[] = $r;
    $db->close();
    return $rows;
}

function getBotStats(): array {
    $db = dbConn();
    $res = $db->query("SELECT COUNT(*),SUM(is_premium),SUM(total_combos),SUM(total_checks) FROM users")->fetchArray(SQLITE3_NUM);
    $db->close();
    return $res;
}

function findUserByUsername(string $username): ?array {
    $db = dbConn();
    $stmt = $db->prepare("SELECT user_id,username FROM users WHERE username=:un");
    $stmt->bindValue(':un', $username);
    $r = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
    $db->close();
    return $r ?: null;
}

function getAllUsers(): array {
    $db = dbConn();
    $res = $db->query("SELECT user_id,username,first_name FROM users");
    $rows = [];
    while ($r = $res->fetchArray(SQLITE3_ASSOC)) $rows[] = $r;
    $db->close();
    return $rows;
}

// Next step handler storage (SQLite-backed for webhook mode)
function setNextStep(int $userId, string $step, string $extra = ''): void {
    $db = dbConn();
    $stmt = $db->prepare("INSERT OR REPLACE INTO next_steps (user_id,step,extra,ts) VALUES (:uid,:step,:extra,:ts)");
    $stmt->bindValue(':uid', $userId, SQLITE3_INTEGER);
    $stmt->bindValue(':step', $step);
    $stmt->bindValue(':extra', $extra);
    $stmt->bindValue(':ts', time(), SQLITE3_INTEGER);
    $stmt->execute();
    $db->close();
}

function getNextStep(int $userId): ?array {
    $db = dbConn();
    $stmt = $db->prepare("SELECT step,extra FROM next_steps WHERE user_id=:uid");
    $stmt->bindValue(':uid', $userId, SQLITE3_INTEGER);
    $r = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
    $db->close();
    return $r ?: null;
}

function clearNextStep(int $userId): void {
    $db = dbConn();
    $stmt = $db->prepare("DELETE FROM next_steps WHERE user_id=:uid");
    $stmt->bindValue(':uid', $userId, SQLITE3_INTEGER);
    $stmt->execute();
    $db->close();
}

// ══════════════════════════════════════════════════════════════
//  LANGUAGE HELPERS
// ══════════════════════════════════════════════════════════════
function getLang(int $userId): string {
    $l = dbGet($userId, 'language');
    return in_array($l, ['tr','en','ar']) ? $l : 'tr';
}

function s(int $userId, string $key, array $vars = []): string {
    global $S;
    $l   = getLang($userId);
    $txt = $S[$l][$key] ?? ($S['tr'][$key] ?? $key);
    foreach ($vars as $k => $v) {
        $txt = str_replace('{' . $k . '}', $v, $txt);
    }
    return $txt;
}

function lt(int $userId, array $d, string $fallback = 'tr'): string {
    $l = getLang($userId);
    return $d[$l] ?? $d[$fallback] ?? '';
}

function apiPref(int $userId): int {
    $v = dbGet($userId, 'api_pref');
    return $v !== null ? (int)$v : 0;
}

// ══════════════════════════════════════════════════════════════
//  TELEGRAM API WRAPPER
// ══════════════════════════════════════════════════════════════
function tgRequest(string $method, array $params = [], string $token = BOT_TOKEN): ?array {
    $url = 'https://api.telegram.org/bot' . $token . '/' . $method;
    $ch  = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $params,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 30,
    ]);
    $res = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($res, true);
    return ($data && $data['ok']) ? $data['result'] : null;
}

function sendMessage(int $chatId, string $text, array $extra = [], string $token = BOT_TOKEN): ?array {
    $params = array_merge([
        'chat_id'    => $chatId,
        'text'       => $text,
        'parse_mode' => 'HTML',
    ], $extra);
    return tgRequest('sendMessage', $params, $token);
}

function editMessageText(int $chatId, int $msgId, string $text, array $extra = [], string $token = BOT_TOKEN): void {
    $params = array_merge([
        'chat_id'    => $chatId,
        'message_id' => $msgId,
        'text'       => $text,
        'parse_mode' => 'HTML',
    ], $extra);
    tgRequest('editMessageText', $params, $token);
}

function editMessageReplyMarkup(int $chatId, int $msgId, string $kb, string $token = BOT_TOKEN): void {
    tgRequest('editMessageReplyMarkup', [
        'chat_id'      => $chatId,
        'message_id'   => $msgId,
        'reply_markup' => $kb,
    ], $token);
}

function answerCallbackQuery(string $callId, string $text = '', bool $alert = false, string $token = BOT_TOKEN): void {
    tgRequest('answerCallbackQuery', [
        'callback_query_id' => $callId,
        'text'              => $text,
        'show_alert'        => $alert ? 'true' : 'false',
    ], $token);
}

function deleteMessage(int $chatId, int $msgId, string $token = BOT_TOKEN): void {
    tgRequest('deleteMessage', ['chat_id' => $chatId, 'message_id' => $msgId], $token);
}

function sendDocument(int $chatId, string $filePath, string $caption = '', string $token = BOT_TOKEN): void {
    $params = [
        'chat_id'    => $chatId,
        'document'   => new CURLFile($filePath),
        'parse_mode' => 'HTML',
    ];
    if ($caption) $params['caption'] = $caption;
    tgRequest('sendDocument', $params, $token);
}

function sendVideo(int $chatId, string $filePath, string $caption = '', string $token = BOT_TOKEN): void {
    tgRequest('sendVideo', [
        'chat_id'            => $chatId,
        'video'              => new CURLFile($filePath),
        'caption'            => $caption,
        'parse_mode'         => 'HTML',
        'supports_streaming' => 'true',
    ], $token);
}

function sendInvoice(int $chatId, int $userId, string $token = BOT_TOKEN): void {
    tgRequest('sendInvoice', [
        'chat_id'         => $chatId,
        'title'           => 'Cyber Searcher Premium',
        'description'     => '30+ OSINT sorgusu — sınırsız kullanım',
        'payload'         => 'prem',
        'provider_token'  => '',
        'currency'        => 'XTR',
        'prices'          => json_encode([['label' => '⭐ Premium Üyelik', 'amount' => PREMIUM_PRICE]]),
    ], $token);
}

function answerPreCheckoutQuery(string $id, bool $ok = true, string $token = BOT_TOKEN): void {
    tgRequest('answerPreCheckoutQuery', [
        'pre_checkout_query_id' => $id,
        'ok'                    => $ok ? 'true' : 'false',
    ], $token);
}

// ══════════════════════════════════════════════════════════════
//  KEYBOARDS
// ══════════════════════════════════════════════════════════════
function inlineKb(array $rows): string {
    return json_encode(['inline_keyboard' => $rows]);
}

function replyKb(array $rows, bool $resize = true): string {
    return json_encode(['keyboard' => $rows, 'resize_keyboard' => $resize]);
}

function mainKb(int $userId): string {
    $l = getLang($userId);
    $labels = [
        'tr' => ['📦 Combo Çek','🛠 Araçlar','📊 İstatistik','👤 Profil','🏆 Lider Tablosu','⚙️ API Değiştir','❓ Yardım'],
        'en' => ['📦 Combo Check','🛠 Tools','📊 Statistics','👤 Profile','🏆 Leaderboard','⚙️ Change API','❓ Help'],
        'ar' => ['📦 فحص كومبو','🛠 الأدوات','📊 الإحصائيات','👤 الملف الشخصي','🏆 المتصدرون','⚙️ تغيير API','❓ مساعدة'],
    ];
    $btns = $labels[$l] ?? $labels['tr'];
    $rows = [];
    $chunk = array_chunk($btns, 2);
    foreach ($chunk as $row) {
        $rows[] = array_map(fn($b) => ['text' => $b], $row);
    }
    return replyKb($rows);
}

function btn(string $text, string $cd): array {
    return ['text' => $text, 'callback_data' => $cd];
}

function sep(string $text): array {
    return ['text' => "─── {$text} ───", 'callback_data' => 'noop'];
}

function toolsKb(int $userId): string {
    $lsTxt = isPremium($userId) ? '🌍 LeakSights OSINT ⭐' : '🌍 LeakSights OSINT 🔒';
    $rows = [
        [btn('🇹🇷 Türkiye Sorguları','menu_turkey'), btn($lsTxt,'menu_ls')],
        [btn('🎮 MC Bedrock','tool_bedrock'),         btn('💳 CC Generator','tool_ccgen')],
        [btn('🤖 Discord Token','tool_dctoken'),      btn('✈️ TG Token','tool_tgtoken')],
        [btn('💊 Eczane','tool_eczane'),              btn('🌐 IP Bilgi','tool_ipinfo')],
        [btn('🔎 DNS Sorgu','tool_dns'),              btn('⚽ Bahis Sorgu','tool_bahis')],
        [btn('🚗 Plaka Sorgu','tool_plaka'),          btn('💎 PreDunyam','tool_predunyam')],
        [btn('🛡️ Proxy Check','tool_proxycheck'),     btn('🔍 URL Scan','tool_urlscan')],
        [btn('🎥 Video İndir','tool_video'),          btn('🤖 Bot Ekle','tool_addbot')],
        [btn(s($userId,'home_btn'),'goto_home')],
    ];
    return inlineKb($rows);
}

function turkeyKb(int $userId): string {
    global $TURKIYE_API;
    $l = getLang($userId);
    $lbl = fn($k) => $TURKIYE_API[$k][$l] ?? $TURKIYE_API[$k]['tr'];
    $rows = [
        [sep('👤 KİMLİK')],
        [btn("{$TURKIYE_API['tc']['icon']} {$lbl('tc')}",'tr_tc'), btn("{$TURKIYE_API['tcpro']['icon']} {$lbl('tcpro')}",'tr_tcpro')],
        [btn("{$TURKIYE_API['adsoyad']['icon']} {$lbl('adsoyad')}",'tr_adsoyad')],
        [sep('👨‍👩‍👧 AİLE')],
        [btn("{$TURKIYE_API['aile']['icon']} {$lbl('aile')}",'tr_aile'), btn("{$TURKIYE_API['ailepro']['icon']} {$lbl('ailepro')}",'tr_ailepro')],
        [btn("{$TURKIYE_API['sulale']['icon']} {$lbl('sulale')}",'tr_sulale')],
        [sep('📱 İLETİŞİM')],
        [btn("{$TURKIYE_API['tcgsm']['icon']} {$lbl('tcgsm')}",'tr_tcgsm'), btn("{$TURKIYE_API['gsmtc']['icon']} {$lbl('gsmtc')}",'tr_gsmtc')],
        [sep('🏠 MÜLK / EĞİTİM')],
        [btn("{$TURKIYE_API['tapu']['icon']} {$lbl('tapu')}",'tr_tapu'), btn("{$TURKIYE_API['eokul']['icon']} {$lbl('eokul')}",'tr_eokul')],
        [btn("{$TURKIYE_API['adaparsel']['icon']} {$lbl('adaparsel')}",'tr_adaparsel')],
        [btn(s($userId,'tools_btn'),'goto_tools'), btn(s($userId,'home_btn'),'goto_home')],
    ];
    return inlineKb($rows);
}

function lsKb(int $userId): string {
    global $LEAKSIGHTS_API, $LEAKSIGHTS_CATS;
    if (!isPremium($userId)) {
        return inlineKb([
            [btn(s($userId,'buy_btn'),'buy_premium')],
            [btn(s($userId,'back_btn'),'goto_tools')],
        ]);
    }
    $l = getLang($userId);
    $catOrder = ['username','name','contact','ip','domain','url','identity','other'];
    $groups = [];
    foreach ($LEAKSIGHTS_API as $key => $info) {
        $cat = $info['cat'] ?? 'other';
        $groups[$cat][] = [$key, $info];
    }
    $rows = [];
    foreach ($catOrder as $cat) {
        if (empty($groups[$cat])) continue;
        $rows[] = [sep($LEAKSIGHTS_CATS[$cat][$l] ?? $cat)];
        foreach ($groups[$cat] as [$key, $info]) {
            $label = "{$info['icon']} " . ($info[$l] ?? $info['tr'] ?? $key);
            $rows[] = [btn($label, "ls_{$key}")];
        }
    }
    $rows[] = [btn(s($userId,'tools_btn'),'goto_tools'), btn(s($userId,'home_btn'),'goto_home')];
    return inlineKb($rows);
}

function premiumKb(int $userId): string {
    return inlineKb([
        [btn(s($userId,'buy_btn'),'pay_premium')],
        [btn(s($userId,'home_btn'),'goto_home')],
    ]);
}

function langKb(): string {
    return inlineKb([[
        ['text' => '🇹🇷 Türkçe', 'callback_data' => 'lang_tr'],
        ['text' => '🇬🇧 English','callback_data' => 'lang_en'],
        ['text' => '🇸🇦 العربية','callback_data' => 'lang_ar'],
    ]]);
}

// ══════════════════════════════════════════════════════════════
//  ENGINE HELPERS
// ══════════════════════════════════════════════════════════════
function apiGet(string $url): array {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_HTTPHEADER     => ['User-Agent: Mozilla/5.0'],
    ]);
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($code !== 200) return [null, "❌ HTTP {$code}"];
    $data = json_decode($body, true);
    if (json_last_error() !== JSON_ERROR_NONE) return [null, "JSON hatası:\n" . substr($body, 0, 300)];
    return [$data, null];
}

function comboEngine(string $domain, ?int $limit): array {
    global $API_LIST, $YASAKLI;
    foreach ($YASAKLI as $bad) {
        if (stripos($domain, $bad) !== false) return [null, "Yasaklı domain: {$bad}", null];
    }

    $combos = [];
    $apis   = [];

    $extract = function (string $line): array {
        if (preg_match('@://[^/]+/[^:]*:(.+?):(.+)$@', $line, $m)) return [trim($m[1]), trim($m[2])];
        $parts = explode(':', $line);
        if (count($parts) >= 2) return [trim($parts[count($parts)-2]), trim($parts[count($parts)-1])];
        return [null, null];
    };

    foreach ($API_LIST as $api) {
        $ch = curl_init($api['url'] . $domain);
        curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_SSL_VERIFYPEER=>false, CURLOPT_TIMEOUT=>10, CURLOPT_HTTPHEADER=>['User-Agent: Mozilla/5.0']]);
        $body = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($code !== 200) continue;
        $data  = json_decode($body, true);
        $lines = [];
        if ($api['type'] === 'wazely')     $lines = $data['foundLines'] ?? [];
        elseif ($api['type'] === 'solidar') $lines = $data['sonuclar'] ?? [];
        elseif ($api['type'] === 'rootturkey') {
            $raw   = is_array($data) ? ($data['data'] ?? '') : $body;
            $lines = explode("\n", $raw);
        }
        foreach ($lines as $line) {
            [$u, $p] = $extract((string)$line);
            if ($u && $p) $combos[] = "{$u}:{$p}";
        }
        $apis[] = $api['name'];
    }

    $uniq = array_unique($combos);
    if ($limit) $uniq = array_slice($uniq, 0, $limit);
    return [array_values($uniq), null, implode(' + ', $apis)];
}

function fmtGeneric(string $title, mixed $data, string $queried, string $extra = ''): string {
    $now   = date('d.m.Y H:i:s');
    $sep   = str_repeat('=', 60);
    $lines = [
        $sep, " {$title}", $sep,
        " Aranan  : {$queried}",
        " Tarih   : {$now}",
        $sep, '',
    ];

    $dump = function (mixed $obj, int $indent = 0) use (&$dump, &$lines): void {
        $prefix = str_repeat('  ', $indent);
        if (is_array($obj) && array_keys($obj) !== range(0, count($obj)-1)) {
            foreach ($obj as $k => $v) {
                if ($v === null || trim((string)$v) === '') continue;
                if (is_array($v)) { $lines[] = "{$prefix}• {$k}:"; $dump($v, $indent+1); }
                else $lines[] = "{$prefix}• {$k}: {$v}";
            }
        } elseif (is_array($obj)) {
            foreach ($obj as $i => $item) {
                $lines[] = "{$prefix}[" . ($i+1) . "]";
                $dump($item, $indent+1);
                $lines[] = '';
            }
        } else {
            if (trim((string)$obj)) $lines[] = "{$prefix}{$obj}";
        }
    };

    $dump($data);
    $lines = array_merge($lines, [
        '', $sep,
        " {$extra} — Cyber Searcher",
        ' Developer: @DevoIoperTeIegram',
        $sep,
    ]);
    return implode("\n", $lines);
}

function sendTxtResult(int $chatId, int $statusMid, string $fname, string $content, string $caption, string $token = BOT_TOKEN): void {
    file_put_contents($fname, $content);
    sendDocument($chatId, $fname, $caption, $token);
    @unlink($fname);
    try { deleteMessage($chatId, $statusMid, $token); } catch (Throwable) {}
}

function proxyCheck(string $ip): string {
    $ch = curl_init("https://proxycheck.io/v3/{$ip}?vpn=1&asn=1&risk=1&port=1");
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_SSL_VERIFYPEER=>false, CURLOPT_TIMEOUT=>15]);
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($code !== 200) return "❌ HTTP {$code}";
    $d = json_decode($body, true);
    if (!isset($d[$ip])) return '❌ IP bulunamadı.';
    $info = $d[$ip];
    $loc  = $info['location'] ?? [];
    $det  = $info['detections'] ?? [];
    $net  = $info['network'] ?? [];
    $sep  = str_repeat('=', 60);
    $yesno = fn($v) => $v ? '⚠️ Evet' : '✅ Hayır';
    $lines = [
        $sep,' 🛡️ PROXYCHECK.IO',$sep,
        " IP: {$ip}",'',
        ' 📡 AĞ',
        "  ASN        : " . ($net['asn'] ?? '—'),
        "  Sağlayıcı  : " . ($net['provider'] ?? '—'),
        "  Hostname   : " . ($net['hostname'] ?? '—'),'',
        ' 📍 KONUM',
        "  Ülke  : " . ($loc['country_name'] ?? '—') . " (" . ($loc['country_code'] ?? '—') . ")",
        "  Şehir : " . ($loc['city_name'] ?? '—'),
        "  TZ    : " . ($loc['timezone'] ?? '—'),'',
        ' 🔍 TESPİT',
        "  Proxy    : " . $yesno($det['proxy'] ?? false),
        "  VPN      : " . $yesno($det['vpn'] ?? false),
        "  TOR      : " . $yesno($det['tor'] ?? false),
        "  Hosting  : " . $yesno($det['hosting'] ?? false),
        "  Risk     : " . ($det['risk'] ?? 0) . "%",'',
        $sep,' @DevoIoperTeIegram',$sep,
    ];
    return implode("\n", $lines);
}

function urlScan(string $domain): string {
    $ch = curl_init("https://urlscan.io/api/v1/search/?q={$domain}");
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_SSL_VERIFYPEER=>false, CURLOPT_TIMEOUT=>15, CURLOPT_HTTPHEADER=>['User-Agent: Mozilla/5.0']]);
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($code !== 200) return "❌ HTTP {$code}";
    $data    = json_decode($body, true);
    $results = $data['results'] ?? [];
    if (!$results) return "🔍 {$domain} için sonuç bulunamadı.";
    $sep   = str_repeat('=', 60);
    $lines = [$sep, " 🔍 URLSCAN.IO — {$domain}", $sep,''];
    foreach (array_slice($results, 0, 5) as $i => $res) {
        $task  = $res['task'] ?? [];
        $page  = $res['page'] ?? [];
        $n     = $i + 1;
        $lines = array_merge($lines, [
            " SONUÇ #{$n}",
            "  URL    : " . ($task['url'] ?? '—'),
            "  IP     : " . ($page['ip'] ?? '—'),
            "  Ülke   : " . ($page['country'] ?? '—'),
            "  Başlık : " . ($page['title'] ?? '—'),
            "  Durum  : " . ($page['status'] ?? '—'),'',
        ]);
    }
    $lines = array_merge($lines, [$sep,' @DevoIoperTeIegram',$sep]);
    return implode("\n", $lines);
}

// ══════════════════════════════════════════════════════════════
//  DISPLAY HELPERS
// ══════════════════════════════════════════════════════════════
function showStats(int $chatId, int $uid, string $token = BOT_TOKEN): void {
    $row = getUserStats($uid);
    if (!$row) { sendMessage($chatId, s($uid,'no_stats'), [], $token); return; }
    $status = $row['is_premium'] ? s($uid,'premium_on') : s($uid,'free');
    $txt    = s($uid,'stats_title') . "\n" . str_repeat('─',30) . "\n\n"
            . "🔍 Sorgu: <b>{$row['total_checks']}</b>\n"
            . "📦 Combo: <b>{$row['total_combos']}</b>\n"
            . "📌 Durum: <b>{$status}</b>\n";
    if ($row['is_premium'] && $row['premium_date']) $txt .= "📅 Premium: <b>{$row['premium_date']}</b>\n";
    $txt .= "\n👨‍💻 @DevoIoperTeIegram";
    sendMessage($chatId, $txt, [], $token);
}

function showProfile(int $chatId, int $uid, string $token = BOT_TOKEN): void {
    $row = getUserStats($uid);
    if (!$row) { sendMessage($chatId, s($uid,'no_stats'), [], $token); return; }
    $status = $row['is_premium'] ? s($uid,'premium_on') : s($uid,'free');
    $txt    = s($uid,'profile_title') . "\n" . str_repeat('─',30) . "\n\n"
            . "🆔 ID: <code>{$uid}</code>\n"
            . "👤 User: @" . ($row['username'] ?: '—') . "\n"
            . "📛 İsim: " . ($row['first_name'] ?: '—') . "\n"
            . "📌 Durum: <b>{$status}</b>\n";
    if ($row['is_premium'] && $row['premium_date']) $txt .= "📅 Premium: <b>{$row['premium_date']}</b>\n";
    $txt .= "\n📊 <b>İstatistikler</b>\n"
          . "🔍 Sorgu: <b>{$row['total_checks']}</b>\n"
          . "📦 Combo: <b>{$row['total_combos']}</b>\n"
          . "📅 Katılım: {$row['join_date']}\n\n"
          . "👨‍💻 @DevoIoperTeIegram";
    sendMessage($chatId, $txt, [], $token);
}

function showLeaderboard(int $chatId, int $uid, string $token = BOT_TOKEN): void {
    $users  = getLeaderboard(10);
    if (!$users) { sendMessage($chatId, s($uid,'lb_title') . "\n\n❌ Henüz veri yok.", [], $token); return; }
    $medals = ['🥇','🥈','🥉','4️⃣','5️⃣','6️⃣','7️⃣','8️⃣','9️⃣','🔟'];
    $txt    = s($uid,'lb_title') . "\n" . str_repeat('─',30) . "\n\n";
    foreach ($users as $i => $u) {
        $nm  = substr($u['first_name'] ?: $u['username'] ?: (string)$u['user_id'], 0, 15);
        $pk  = $u['is_premium'] ? '⭐' : '';
        $txt .= "{$medals[$i]} <b>{$nm}</b> {$pk}\n   📦 {$u['total_combos']}  🔍 {$u['total_checks']}\n\n";
    }
    $txt .= '👨‍💻 @DevoIoperTeIegram';
    sendMessage($chatId, $txt, [], $token);
}

function showApiMenu(int $chatId, int $uid, ?array $edit = null, string $token = BOT_TOKEN): void {
    global $API_LIST;
    $cur     = apiPref($uid);
    $curName = $API_LIST[$cur]['name'] ?? 'Varsayılan';
    $txt     = s($uid, 'api_title', ['cur' => $curName]);
    $rows    = [];
    foreach ($API_LIST as $i => $api) {
        $ico    = ($i === $cur) ? '✅' : '◻️';
        $rows[] = [btn("{$ico} {$api['name']}", "setapi_{$i}")];
    }
    $rows[] = [btn('🔄 Varsayılan','setapi_default')];
    $rows[] = [btn(s($uid,'home_btn'),'goto_home')];
    $kb     = inlineKb($rows);
    if ($edit) {
        editMessageText($edit[0], $edit[1], $txt, ['reply_markup' => $kb], $token);
    } else {
        sendMessage($chatId, $txt, ['reply_markup' => $kb], $token);
    }
}

function showHelp(int $chatId, int $uid, string $token = BOT_TOKEN): void {
    $status = isPremium($uid) ? s($uid,'premium_on') : s($uid,'free');
    $l      = getLang($uid);
    $help   = match($l) {
        'en' => "📖 <b>HELP MENU</b>\n📌 Status: {$status}\n══════════════════════\n\n🔹 <b>QUERY SYSTEMS</b> (🆓 FREE):\n   • 🆔 TC Query\n   • 👤 Name Surname\n   • 🚗 License Plate\n   • 🎓 E-School\n\n🔹 <b>⭐ PREMIUM:</b>\n   • 🌍 LeakSights OSINT (30+ Queries)\n\n🔹 <b>OTHER TOOLS</b> (🆓 FREE):\n   • 📦 Combo Check\n   • 💳 CC Generator\n   • 🌐 IP Info\n   • 🛡️ Proxy Check\n   • 🤖 Add Bot (/addbot)\n\n👨‍💻 @DevoIoperTeIegram",
        'ar' => "📖 <b>قائمة المساعدة</b>\n📌 حالتك: {$status}\n══════════════════════\n\n🔹 <b>أنظمة الاستعلام</b> (🆓 مجاني)\n\n🔹 <b>⭐ بريميوم:</b>\n   • 🌍 LeakSights OSINT\n\n👨‍💻 @DevoIoperTeIegram",
        default => "📖 <b>YARDIM MENÜSÜ</b>\n📌 Durumunuz: {$status}\n══════════════════════\n\n🔹 <b>SORGU SİSTEMLERİ</b> (🆓 ÜCRETSİZ):\n   • 🆔 TC Sorgu\n   • 👤 Ad Soyad\n   • 🚗 Plaka\n   • 🎓 E-Okul\n   • 🏠 Tapu\n\n🔹 <b>⭐ PREMIUM:</b>\n   • 🌍 LeakSights OSINT (30+ Sorgu)\n\n🔹 <b>DİĞER ARAÇLAR</b> (🆓 ÜCRETSİZ):\n   • 📦 Combo Çekme\n   • 💳 CC Generator\n   • 🌐 IP Bilgi\n   • 🛡️ Proxy Check\n   • 🤖 Bot Ekle (/addbot)\n\n👨‍💻 @DevoIoperTeIegram",
    };
    sendMessage($chatId, $help, [], $token);
}

// ══════════════════════════════════════════════════════════════
//  ADMIN HELPERS
// ══════════════════════════════════════════════════════════════
function resolveTarget(string $text): array {
    $text = trim($text);
    if (str_starts_with($text, '@')) {
        $row = findUserByUsername(substr($text, 1));
        return $row ? [(int)$row['user_id'], $row['username']] : [null, null];
    }
    if (ctype_digit($text)) return [(int)$text, $text];
    return [null, null];
}

// ══════════════════════════════════════════════════════════════
//  PROCESS FUNCTIONS
// ══════════════════════════════════════════════════════════════
function processCombo(array $msg, string $token = BOT_TOKEN): void {
    $uid    = $msg['from']['id'];
    $parts  = explode(' ', trim($msg['text']));
    $domain = preg_replace('#https?://|/.*#', '', $parts[0]);
    $limit  = (isset($parts[1]) && ctype_digit($parts[1])) ? (int)$parts[1] : null;
    $chatId = $msg['chat']['id'];

    $sm     = sendMessage($chatId, s($uid,'searching',['domain'=>$domain]), [], $token);
    [$combos, $err, $apis] = comboEngine($domain, $limit);

    if ($err || !$combos) {
        editMessageText($chatId, $sm['message_id'], s($uid,'no_result',['domain'=>$domain]), [], $token);
        return;
    }
    updateStats($uid, count($combos));
    $fname  = sys_get_temp_dir() . "/{$domain}_" . date('Ymd_His') . '.txt';
    $sep    = str_repeat('=', 60);
    $header = "{$sep}\n CYBER SEARCHER — " . strtoupper($domain) . "\n{$sep}\n Toplam: " . count($combos) . "\n Tarih: " . date('d.m.Y H:i') . "\n{$sep}\n\n";
    file_put_contents($fname, $header . implode("\n", $combos) . "\n\n{$sep}\n @DevoIoperTeIegram\n");
    sendDocument($chatId, $fname, s($uid,'combo_caption',['domain'=>$domain,'count'=>count($combos),'apis'=>$apis]), $token);
    @unlink($fname);
    try { deleteMessage($chatId, $sm['message_id'], $token); } catch (Throwable) {}
}

function processTurkey(array $msg, string $tool, string $token = BOT_TOKEN): void {
    global $TURKIYE_API;
    $uid   = $msg['from']['id'];
    $param = trim($msg['text']);
    $l     = getLang($uid);
    $chatId = $msg['chat']['id'];

    $tcTools = ['tc','tcpro','aile','ailepro','sulale','tcgsm','eokul','tapu'];
    if (in_array($tool, $tcTools)) {
        if (!ctype_digit($param) || strlen($param) !== 11) {
            sendMessage($chatId, s($uid,'invalid_tc'), [], $token); return;
        }
    } elseif ($tool === 'gsmtc') {
        $clean = ltrim(preg_replace('/\D/', '', $param), '0');
        if (!ctype_digit($clean) || strlen($clean) !== 10) {
            sendMessage($chatId, s($uid,'invalid_gsm'), [], $token); return;
        }
        $param = $clean;
    } elseif ($tool === 'adsoyad') {
        if (count(explode(' ', trim($param))) < 2) {
            sendMessage($chatId, s($uid,'invalid_adsoyad'), [], $token); return;
        }
    } elseif ($tool === 'adaparsel') {
        if (!str_contains($param, ',')) {
            sendMessage($chatId, s($uid,'invalid_adaparsel'), [], $token); return;
        }
    }

    $sm  = sendMessage($chatId, s($uid,'processing'), [], $token);
    $cfg = $TURKIYE_API[$tool];
    $url = $cfg['url'];

    if ($tool === 'adsoyad') {
        $pts = explode(' ', $param, 2);
        $url = str_replace(['{ad}','{soyad}'], [$pts[0], $pts[1] ?? ''], $url);
    } elseif ($tool === 'gsmtc') {
        $url = str_replace('{gsm}', $param, $url);
    } elseif ($tool === 'adaparsel') {
        $pts = explode(',', $param, 2);
        $url = str_replace(['{il}','{ilce}'], [strtoupper(trim($pts[0])), strtoupper(trim($pts[1]))], $url);
    } else {
        $url = str_replace('{tc}', $param, $url);
    }

    [$data, $err] = apiGet($url);
    if ($err) { editMessageText($chatId, $sm['message_id'], $err, [], $token); return; }

    $title  = "{$cfg['icon']} " . ($cfg[$l] ?? $cfg['tr']);
    $result = fmtGeneric($title, $data, $param, 'Türkiye Sorgu');
    $fname  = sys_get_temp_dir() . "/Turkey_{$tool}_" . date('Ymd_His') . '.txt';
    sendTxtResult($chatId, $sm['message_id'], $fname, $result,
        s($uid,'tr_caption',['tool'=>strtoupper($tool),'param'=>$param,'date'=>date('d.m.Y H:i')]), $token);
}

function processLeakSights(array $msg, string $key, string $token = BOT_TOKEN): void {
    global $LEAKSIGHTS_API;
    $uid    = $msg['from']['id'];
    $val    = trim($msg['text']);
    $chatId = $msg['chat']['id'];
    if (!$val) return;

    $sm   = sendMessage($chatId, s($uid,'processing'), [], $token);
    $info = $LEAKSIGHTS_API[$key] ?? [];
    $url  = str_replace('{value}', urlencode($val), $info['url']);

    [$data, $err] = apiGet($url);
    if ($err) { editMessageText($chatId, $sm['message_id'], $err, [], $token); return; }

    $l      = getLang($uid);
    $title  = "{$info['icon']} LeakSights — " . ($info[$l] ?? $info['tr'] ?? $key);
    $result = fmtGeneric($title, $data, $val, 'LeakSights ⭐');
    $fname  = sys_get_temp_dir() . "/LS_{$key}_" . date('Ymd_His') . '.txt';
    sendTxtResult($chatId, $sm['message_id'], $fname, $result,
        s($uid,'ls_caption',['val'=>$val,'date'=>date('d.m.Y H:i')]), $token);
}

function processGenericTool(array $msg, string $tool, string $token = BOT_TOKEN): void {
    global $TOOLS_API;
    $uid    = $msg['from']['id'];
    $val    = trim($msg['text']);
    $chatId = $msg['chat']['id'];
    $sm     = sendMessage($chatId, s($uid,'processing'), [], $token);

    $ch = curl_init($TOOLS_API[$tool] . $val);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_SSL_VERIFYPEER=>false, CURLOPT_TIMEOUT=>15]);
    $body = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($body, true);
    $out  = $data ? json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) : $body;
    editMessageText($chatId, $sm['message_id'],
        "✅ <b>" . strtoupper($tool) . "</b>\n\n<code>" . substr($out, 0, 4000) . "</code>", [], $token);
}

function processSpecialTool(array $msg, string $tool, string $token = BOT_TOKEN): void {
    $uid    = $msg['from']['id'];
    $val    = trim($msg['text']);
    $chatId = $msg['chat']['id'];
    $sm     = sendMessage($chatId, s($uid,'processing'), [], $token);

    $result = ($tool === 'proxycheck')
        ? proxyCheck($val)
        : urlScan(preg_replace('#https?://|/.*#','', $val));

    if (strlen($result) > 4096) {
        foreach (str_split($result, 4096) as $chunk) {
            sendMessage($chatId, "<code>" . htmlspecialchars($chunk) . "</code>", [], $token);
        }
        try { deleteMessage($chatId, $sm['message_id'], $token); } catch (Throwable) {}
    } else {
        editMessageText($chatId, $sm['message_id'], "<code>" . htmlspecialchars($result) . "</code>", [], $token);
    }
}

function processAddBot(array $msg, string $token = BOT_TOKEN): void {
    $uid    = $msg['from']['id'];
    $newTok = trim($msg['text']);
    $chatId = $msg['chat']['id'];
    if (strlen($newTok) < 30) {
        sendMessage($chatId, '❌ Geçersiz token formatı!', [], $token); return;
    }
    $registry = loadRegistry();
    if (isset($registry[$newTok])) {
        sendMessage($chatId, s($uid,'multi_bot_exists'), [], $token); return;
    }
    $ok = spawnBot($newTok, $uid);
    if ($ok) {
        sendMessage($chatId, s($uid,'multi_bot_added',['token'=>substr($newTok,0,20).'...','owner'=>$msg['from']['first_name'] ?? (string)$uid]), [], $token);
    } else {
        sendMessage($chatId, '❌ Bot başlatılamadı!', [], $token);
    }
}

// ══════════════════════════════════════════════════════════════
//  ADMIN ANNOUNCE
// ══════════════════════════════════════════════════════════════
function doAnnounce(array $msg, string $announcement, string $token = BOT_TOKEN): void {
    $uid    = $msg['from']['id'];
    $chatId = $msg['chat']['id'];
    $users  = getAllUsers();
    $sent   = 0; $failed = 0;
    foreach ($users as $u) {
        $txt = s($uid,'announce_title') . "\n\n{$announcement}\n\n📅 " . date('d.m.Y H:i');
        $res = sendMessage((int)$u['user_id'], $txt, [], $token);
        $res ? $sent++ : $failed++;
        usleep(100000);
    }
    $registry = loadRegistry();
    foreach ($registry as $tok => $info) {
        if ($info['owner_id'] ?? null) {
            sendMessage((int)$info['owner_id'], "📢 <b>DUYURU</b>\n\n{$announcement}\n\n📅 " . date('d.m.Y H:i'), [], $tok);
        }
    }
    sendMessage($chatId, s($uid,'announce_sent') . "\n\n✅ Başarılı: {$sent}\n❌ Başarısız: {$failed}\n👥 Toplam: " . ($sent+$failed), [], $token);
}

// ══════════════════════════════════════════════════════════════
//  MAIN UPDATE HANDLER
// ══════════════════════════════════════════════════════════════
function handleUpdate(array $update, string $token = BOT_TOKEN): void {
    global $TURKIYE_API, $LEAKSIGHTS_API, $TOOLS_API, $TOOL_PROMPTS, $TURKEY_PROMPTS, $API_LIST;

    // ── CALLBACK QUERY ──────────────────────────────────────────
    if (isset($update['callback_query'])) {
        $call   = $update['callback_query'];
        $uid    = $call['from']['id'];
        $data   = $call['data'];
        $chatId = $call['message']['chat']['id'];
        $msgId  = $call['message']['message_id'];
        $callId = $call['id'];

        if (str_starts_with($data, 'lang_')) {
            $l    = substr($data, 5);
            dbSet($uid, 'language', $l);
            $name = $call['from']['first_name'] ?? 'User';
            $status = isPremium($uid) ? s($uid,'premium_on') : s($uid,'free');
            answerCallbackQuery($callId, s($uid,'lang_ok'), false, $token);
            try { deleteMessage($chatId, $msgId, $token); } catch (Throwable) {}
            sendMessage($chatId, s($uid,'welcome',['name'=>$name,'status'=>$status]), ['reply_markup'=>mainKb($uid)], $token);
            return;
        }

        if ($data === 'noop') { answerCallbackQuery($callId, '', false, $token); return; }

        if ($data === 'goto_home') {
            try { deleteMessage($chatId, $msgId, $token); } catch (Throwable) {}
            sendMessage($chatId, '🏠', ['reply_markup'=>mainKb($uid)], $token);
            answerCallbackQuery($callId, '', false, $token);
            return;
        }

        if ($data === 'goto_tools') {
            editMessageText($chatId, $msgId, s($uid,'select_op'), ['reply_markup'=>toolsKb($uid)], $token);
            answerCallbackQuery($callId, '', false, $token);
            return;
        }

        if ($data === 'menu_turkey') {
            editMessageReplyMarkup($chatId, $msgId, turkeyKb($uid), $token);
            answerCallbackQuery($callId, '', false, $token);
            return;
        }

        if ($data === 'menu_ls') {
            if (!isPremium($uid)) {
                $kb  = inlineKb([[btn(s($uid,'buy_btn'),'buy_premium')],[btn(s($uid,'back_btn'),'goto_tools')]]);
                $txt = "🔒 <b>LeakSights OSINT — Premium</b>\n\n" . s($uid,'premium_price_txt') . "\n" . s($uid,'premium_dur') . "\n\n" . s($uid,'premium_features');
                editMessageText($chatId, $msgId, $txt, ['reply_markup'=>$kb], $token);
            } else {
                editMessageReplyMarkup($chatId, $msgId, lsKb($uid), $token);
            }
            answerCallbackQuery($callId, '', false, $token);
            return;
        }

        if ($data === 'buy_premium') {
            if (isPremium($uid)) { answerCallbackQuery($callId, s($uid,'already_premium'), true, $token); return; }
            $txt = s($uid,'premium_title') . "\n" . str_repeat('─',30) . "\n\n" . s($uid,'premium_price_txt') . "\n" . s($uid,'premium_dur') . "\n\n" . s($uid,'premium_features');
            editMessageText($chatId, $msgId, $txt, ['reply_markup'=>premiumKb($uid)], $token);
            answerCallbackQuery($callId, '', false, $token);
            return;
        }

        if ($data === 'pay_premium') {
            if (isPremium($uid)) { answerCallbackQuery($callId, s($uid,'already_premium'), true, $token); return; }
            sendInvoice($chatId, $uid, $token);
            answerCallbackQuery($callId, '', false, $token);
            return;
        }

        if ($data === 'tool_addbot') {
            $prompt = $TOOL_PROMPTS[getLang($uid)]['addbot'] ?? '🤖 Bot Token girin:';
            sendMessage($chatId, $prompt, [], $token);
            setNextStep($uid, 'addbot');
            answerCallbackQuery($callId, '', false, $token);
            return;
        }

        if (str_starts_with($data, 'tr_')) {
            $key    = substr($data, 3);
            $prompt = $TURKEY_PROMPTS[getLang($uid)][$key] ?? s($uid,'enter_val');
            sendMessage($chatId, s($uid,'tr_ask',['prompt'=>$prompt]), [], $token);
            setNextStep($uid, 'turkey', $key);
            answerCallbackQuery($callId, '', false, $token);
            return;
        }

        if (str_starts_with($data, 'ls_')) {
            if (!isPremium($uid)) { answerCallbackQuery($callId, s($uid,'premium_req'), true, $token); return; }
            $key  = substr($data, 3);
            $info = $LEAKSIGHTS_API[$key] ?? [];
            sendMessage($chatId, s($uid,'ls_ask',['icon'=>$info['icon']??'🔍','tool'=>$info[getLang($uid)]??$info['tr']??$key]), [], $token);
            setNextStep($uid, 'ls', $key);
            answerCallbackQuery($callId, '', false, $token);
            return;
        }

        if (str_starts_with($data, 'tool_')) {
            $key = substr($data, 5);
            if ($key === 'video') {
                sendMessage($chatId, s($uid,'video_ask'), [], $token);
                setNextStep($uid, 'video');
            } elseif ($key === 'predunyam') {
                $ch = curl_init($TOOLS_API['predunyam']);
                curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_SSL_VERIFYPEER=>false, CURLOPT_TIMEOUT=>10]);
                $res = curl_exec($ch); curl_close($ch);
                sendMessage($chatId, "💎 <b>PreDunyam</b>\n\n<code>" . htmlspecialchars(substr($res,0,4000)) . "</code>", [], $token);
            } elseif ($key === 'proxycheck' || $key === 'urlscan') {
                $prompt = $TOOL_PROMPTS[getLang($uid)][$key] ?? s($uid,'enter_val');
                sendMessage($chatId, $prompt, [], $token);
                setNextStep($uid, 'special_tool', $key);
            } elseif (isset($TOOLS_API[$key])) {
                $prompt = $TOOL_PROMPTS[getLang($uid)][$key] ?? s($uid,'enter_val');
                sendMessage($chatId, $prompt, [], $token);
                setNextStep($uid, 'generic_tool', $key);
            }
            answerCallbackQuery($callId, '', false, $token);
            return;
        }

        if (str_starts_with($data, 'setapi_')) {
            $val = substr($data, 7);
            if ($val === 'default') {
                dbSet($uid, 'api_pref', 0);
                answerCallbackQuery($callId, '✅ Varsayılan API', false, $token);
            } else {
                $idx = (int)$val;
                dbSet($uid, 'api_pref', $idx);
                answerCallbackQuery($callId, "✅ {$API_LIST[$idx]['name']}", false, $token);
            }
            showApiMenu($chatId, $uid, [$chatId, $msgId], $token);
            return;
        }

        if (str_starts_with($data, 'adm_')) {
            if ($uid !== ADMIN_ID) { answerCallbackQuery($callId, s($uid,'admin_only'), true, $token); return; }
            $action = substr($data, 4);
            handleAdminCallback($call, $action, $token);
            return;
        }

        answerCallbackQuery($callId, '', false, $token);
        return;
    }

    // ── PRE-CHECKOUT QUERY ──────────────────────────────────────
    if (isset($update['pre_checkout_query'])) {
        answerPreCheckoutQuery($update['pre_checkout_query']['id'], true, $token);
        return;
    }

    // ── MESSAGES ────────────────────────────────────────────────
    if (!isset($update['message'])) return;
    $msg    = $update['message'];
    $uid    = $msg['from']['id'] ?? 0;
    $chatId = $msg['chat']['id'];
    $text   = trim($msg['text'] ?? '');

    // Successful payment
    if (isset($msg['successful_payment'])) {
        $uname = $msg['from']['username'] ?? $msg['from']['first_name'] ?? (string)$uid;
        setPremium($uid, $uname);
        sendMessage($chatId, s($uid,'prem_ok'), [], $token);
        sendMessage(ADMIN_ID, "⭐ <b>YENİ PREMIUM</b>\n👤 @{$uname}\n🆔 {$uid}\n💰 " . PREMIUM_PRICE . " Stars\n📅 " . date('d.m.Y H:i'), [], $token);
        return;
    }

    addUser($uid, $msg['from']['username'] ?? '', $msg['from']['first_name'] ?? '');

    // Next step handler
    $ns = getNextStep($uid);
    if ($ns && $text) {
        clearNextStep($uid);
        match($ns['step']) {
            'combo'       => processCombo(array_merge($msg, ['text' => $text]), $token),
            'turkey'      => processTurkey($msg, $ns['extra'], $token),
            'ls'          => processLeakSights($msg, $ns['extra'], $token),
            'generic_tool'=> processGenericTool($msg, $ns['extra'], $token),
            'special_tool'=> processSpecialTool($msg, $ns['extra'], $token),
            'addbot'      => processAddBot($msg, $token),
            'video'       => processVideo($msg, $token),
            'admin_give'  => adminGive($msg, $token),
            'admin_remove'=> adminRemove($msg, $token),
            'admin_announce'=> adminAnnounceStep($msg, $token),
            default       => null,
        };
        return;
    }

    // Commands
    if (str_starts_with($text, '/')) {
        $parts = explode(' ', $text, 2);
        $cmd   = strtolower(explode('@', $parts[0])[0]);
        $args  = $parts[1] ?? '';

        match ($cmd) {
            '/start'      => handleStart($msg, $token),
            '/premium'    => handlePremium($msg, $token),
            '/video'      => handleVideo($msg, $token),
            '/admin'      => handleAdmin($msg, $token),
            '/addbot'     => handleAddBotCmd($msg, $args, $token),
            '/removebot'  => handleRemoveBot($msg, $args, $token),
            '/listbots'   => handleListBots($msg, $token),
            '/duyuru'     => handleAnnounce($msg, $args, $token),
            default       => null,
        };
        return;
    }

    // Menu buttons
    $menuKeys = [
        'tr' => ['combo'=>'📦 Combo Çek','tools'=>'🛠 Araçlar','stats'=>'📊 İstatistik','profile'=>'👤 Profil','lb'=>'🏆 Lider Tablosu','api'=>'⚙️ API Değiştir','help'=>'❓ Yardım'],
        'en' => ['combo'=>'📦 Combo Check','tools'=>'🛠 Tools','stats'=>'📊 Statistics','profile'=>'👤 Profile','lb'=>'🏆 Leaderboard','api'=>'⚙️ Change API','help'=>'❓ Help'],
        'ar' => ['combo'=>'📦 فحص كومبو','tools'=>'🛠 الأدوات','stats'=>'📊 الإحصائيات','profile'=>'👤 الملف الشخصي','lb'=>'🏆 المتصدرون','api'=>'⚙️ تغيير API','help'=>'❓ مساعدة'],
    ];
    $keys = $menuKeys[getLang($uid)] ?? $menuKeys['tr'];
    $key  = array_search($text, $keys);

    match ($key) {
        'combo'   => (function() use ($uid, $chatId, $msg, $token, $menuKeys) {
            $m = sendMessage($chatId, s($uid,'combo_ask'), [], $token);
            setNextStep($uid, 'combo');
        })(),
        'tools'   => sendMessage($chatId, s($uid,'select_op'), ['reply_markup'=>toolsKb($uid)], $token),
        'stats'   => showStats($chatId, $uid, $token),
        'profile' => showProfile($chatId, $uid, $token),
        'lb'      => showLeaderboard($chatId, $uid, $token),
        'api'     => showApiMenu($chatId, $uid, null, $token),
        'help'    => showHelp($chatId, $uid, $token),
        default   => null,
    };
}

// ══════════════════════════════════════════════════════════════
//  COMMAND HANDLERS
// ══════════════════════════════════════════════════════════════
function handleStart(array $msg, string $token): void {
    $uid    = $msg['from']['id'];
    $chatId = $msg['chat']['id'];
    sendMessage($chatId, s($uid,'lang_pick'), ['reply_markup'=>langKb()], $token);
}

function handlePremium(array $msg, string $token): void {
    $uid    = $msg['from']['id'];
    $chatId = $msg['chat']['id'];
    if (isPremium($uid)) { sendMessage($chatId, s($uid,'already_premium'), [], $token); return; }
    $txt = s($uid,'premium_title') . "\n" . str_repeat('─',30) . "\n\n" . s($uid,'premium_price_txt') . "\n" . s($uid,'premium_dur') . "\n\n" . s($uid,'premium_features');
    sendMessage($chatId, $txt, ['reply_markup'=>premiumKb($uid)], $token);
}

function handleVideo(array $msg, string $token): void {
    $uid    = $msg['from']['id'];
    $chatId = $msg['chat']['id'];
    sendMessage($chatId, s($uid,'video_ask'), [], $token);
    setNextStep($uid, 'video');
}

function handleAdmin(array $msg, string $token): void {
    $uid    = $msg['from']['id'];
    $chatId = $msg['chat']['id'];
    if ($uid !== ADMIN_ID) { sendMessage($chatId, s($uid,'admin_only'), [], $token); return; }
    $rows = [
        [btn('📊 Bot İstatistik','adm_stats'),       btn('⭐ Premium Kullanıcılar','adm_prem_users')],
        [btn('📋 Premium Log','adm_prem_log'),        btn('➕ Premium Ver','adm_give')],
        [btn('➖ Premium Kaldır','adm_remove'),       btn('📢 Duyuru Gönder','adm_announce')],
        [btn('🤖 Tüm Botları Listele','adm_listbots')],
    ];
    sendMessage($chatId, '👑 <b>ADMIN PANELİ</b>', ['reply_markup'=>inlineKb($rows)], $token);
}

function handleAddBotCmd(array $msg, string $args, string $token): void {
    $uid    = $msg['from']['id'];
    $chatId = $msg['chat']['id'];
    $newTok = trim($args);
    if (strlen($newTok) < 30) { sendMessage($chatId, s($uid,'multi_bot_add_usage'), [], $token); return; }
    $registry = loadRegistry();
    if (isset($registry[$newTok])) { sendMessage($chatId, s($uid,'multi_bot_exists'), [], $token); return; }
    $ok = spawnBot($newTok, $uid);
    $msg2 = $ok
        ? s($uid,'multi_bot_added',['token'=>substr($newTok,0,20).'...','owner'=>$msg['from']['first_name']??$uid])
        : '❌ Bot başlatılamadı!';
    sendMessage($chatId, $msg2, [], $token);
}

function handleRemoveBot(array $msg, string $args, string $token): void {
    $uid    = $msg['from']['id'];
    $chatId = $msg['chat']['id'];
    if ($uid !== ADMIN_ID) { sendMessage($chatId, s($uid,'admin_only'), [], $token); return; }
    $tok = trim($args);
    $registry = loadRegistry();
    if (!isset($registry[$tok])) { sendMessage($chatId, s($uid,'multi_bot_not_found',['token'=>substr($tok,0,15).'...']), [], $token); return; }
    killBot($tok);
    sendMessage($chatId, s($uid,'multi_bot_removed',['token'=>substr($tok,0,20).'...']), [], $token);
}

function handleListBots(array $msg, string $token): void {
    $uid      = $msg['from']['id'];
    $chatId   = $msg['chat']['id'];
    if ($uid !== ADMIN_ID) { sendMessage($chatId, s($uid,'admin_only'), [], $token); return; }
    $registry = loadRegistry();
    if (!$registry) { sendMessage($chatId, s($uid,'multi_bot_no_bots'), [], $token); return; }
    $lines = [s($uid,'multi_bot_list'), str_repeat('─',30), ''];
    foreach ($registry as $tok => $info) {
        $status = s($uid,'multi_bot_stopped');
        $lines[] = "🔑 `{$tok}`";
        $lines[] = "   📌 {$status}  📅 " . substr($info['added'] ?? '—', 0, 16);
        $lines[] = "   👤 Sahip: " . ($info['owner_id'] ?? '—');
        $lines[] = '';
    }
    $lines[] = s($uid,'multi_bot_total',['count'=>count($registry)]);
    sendMessage($chatId, implode("\n", $lines), [], $token);
}

function handleAnnounce(array $msg, string $args, string $token): void {
    $uid    = $msg['from']['id'];
    $chatId = $msg['chat']['id'];
    if ($uid !== ADMIN_ID) { sendMessage($chatId, s($uid,'admin_only'), [], $token); return; }
    $ann = trim($args);
    if (!$ann) { sendMessage($chatId, s($uid,'announce_usage'), [], $token); return; }
    doAnnounce($msg, $ann, $token);
}

function processVideo(array $msg, string $token): void {
    $uid    = $msg['from']['id'];
    $link   = trim($msg['text']);
    $chatId = $msg['chat']['id'];
    if (!preg_match('#^https?://#', $link)) { sendMessage($chatId, s($uid,'invalid_link'), [], $token); return; }
    $sm   = sendMessage($chatId, s($uid,'video_wait'), [], $token);
    $dir  = sys_get_temp_dir() . '/downloads';
    @mkdir($dir, 0777, true);
    $ytdlp = trim(shell_exec('which yt-dlp 2>/dev/null') ?: '');
    if (!$ytdlp) {
        editMessageText($chatId, $sm['message_id'], s($uid,'video_err',['err'=>'yt-dlp not found']), [], $token);
        return;
    }
    $outTemplate = $dir . '/%(title)s.%(ext)s';
    $cmd  = escapeshellcmd($ytdlp) . ' --format mp4/best --no-playlist --quiet -o ' . escapeshellarg($outTemplate) . ' ' . escapeshellarg($link) . ' 2>&1';
    exec($cmd, $output, $ret);
    if ($ret !== 0) {
        editMessageText($chatId, $sm['message_id'], s($uid,'video_err',['err'=>implode("\n",$output)]), [], $token);
        return;
    }
    $files = glob($dir . '/*');
    if (!$files) {
        editMessageText($chatId, $sm['message_id'], s($uid,'video_err',['err'=>'file not found']), [], $token);
        return;
    }
    $path = end($files);
    $size = round(filesize($path) / 1048576, 1) . 'MB';
    $title = pathinfo($path, PATHINFO_FILENAME);
    sendVideo($chatId, $path, s($uid,'video_caption',['title'=>substr($title,0,60),'size'=>$size,'dur'=>'?','upl'=>'?']), $token);
    @unlink($path);
    try { deleteMessage($chatId, $sm['message_id'], $token); } catch (Throwable) {}
}

// ══════════════════════════════════════════════════════════════
//  ADMIN CALLBACK
// ══════════════════════════════════════════════════════════════
function handleAdminCallback(array $call, string $action, string $token): void {
    $uid    = $call['from']['id'];
    $chatId = $call['message']['chat']['id'];
    $msgId  = $call['message']['message_id'];
    $callId = $call['id'];

    if ($action === 'stats') {
        [$tu, $pu, $tc, $tch] = getBotStats();
        $txt = "📊 <b>BOT İSTATİSTİK</b>\n" . str_repeat('─',30) . "\n\n"
             . "👥 Toplam Kullanıcı: <b>{$tu}</b>\n"
             . "⭐ Premium: <b>" . ($pu ?: 0) . "</b>\n"
             . "📦 Toplam Combo: <b>" . ($tc ?: 0) . "</b>\n"
             . "🔍 Toplam Sorgu: <b>" . ($tch ?: 0) . "</b>";
        editMessageText($chatId, $msgId, $txt, [], $token);
    } elseif ($action === 'prem_users') {
        $users = getPremiumUsers();
        if (!$users) { answerCallbackQuery($callId, 'Henüz premium kullanıcı yok.', false, $token); return; }
        $txt = "⭐ <b>PREMIUM KULLANICILARI</b>\n" . str_repeat('─',30) . "\n\n";
        foreach ($users as $u) $txt .= "👤 @" . ($u['username'] ?: $u['first_name'] ?: $u['user_id']) . "\n   📅 {$u['premium_date']}\n\n";
        editMessageText($chatId, $msgId, $txt, [], $token);
    } elseif ($action === 'prem_log') {
        $logs = getPremiumLogs(20);
        if (!$logs) { answerCallbackQuery($callId, 'Log yok.', false, $token); return; }
        $txt = "📋 <b>PREMIUM LOG</b>\n\n";
        foreach ($logs as $l) $txt .= "👤 @" . ($l['username'] ?: $l['user_id']) . "  💰 {$l['amount']}⭐  📅 {$l['date']}\n";
        editMessageText($chatId, $msgId, substr($txt, 0, 4096), [], $token);
    } elseif ($action === 'give') {
        sendMessage($chatId, '👤 @kullanıcıadı veya ID gir:', [], $token);
        setNextStep($uid, 'admin_give');
    } elseif ($action === 'remove') {
        sendMessage($chatId, '👤 @kullanıcıadı veya ID gir (premium kaldır):', [], $token);
        setNextStep($uid, 'admin_remove');
    } elseif ($action === 'announce') {
        sendMessage($chatId, '📢 Duyuru mesajını gir:', [], $token);
        setNextStep($uid, 'admin_announce');
    } elseif ($action === 'listbots') {
        $registry = loadRegistry();
        if (!$registry) { sendMessage($chatId, s($uid,'multi_bot_no_bots'), [], $token); return; }
        $lines = [s($uid,'multi_bot_list'), str_repeat('─',30), ''];
        foreach ($registry as $tok => $info) {
            $lines[] = "🔑 `{$tok}`";
            $lines[] = "   📅 " . substr($info['added']??'—',0,16) . "  👤 " . ($info['owner_id']??'—');
            $lines[] = '';
        }
        $lines[] = s($uid,'multi_bot_total',['count'=>count($registry)]);
        sendMessage($chatId, implode("\n", $lines), [], $token);
    }
    answerCallbackQuery($callId, '', false, $token);
}

function adminGive(array $msg, string $token): void {
    $uid = $msg['from']['id'];
    [$tid, $tuname] = resolveTarget($msg['text']);
    if (!$tid) { sendMessage($msg['chat']['id'], s($uid,'user_nf'), [], $token); return; }
    setPremium($tid, $tuname ?: (string)$tid);
    sendMessage($msg['chat']['id'], s($uid,'given_ok',['user'=>$tuname??$tid]), [], $token);
    try { sendMessage($tid, '⭐ <b>Premium aktif!</b>\n\nLeakSights OSINT erişimi kazandın.', [], $token); } catch (Throwable) {}
}

function adminRemove(array $msg, string $token): void {
    $uid = $msg['from']['id'];
    [$tid, $tuname] = resolveTarget($msg['text']);
    if (!$tid) { sendMessage($msg['chat']['id'], s($uid,'user_nf'), [], $token); return; }
    removePremium($tid);
    sendMessage($msg['chat']['id'], s($uid,'removed_ok',['user'=>$tuname??$tid]), [], $token);
}

function adminAnnounceStep(array $msg, string $token): void {
    $ann = trim($msg['text']);
    if (!$ann) { sendMessage($msg['chat']['id'], s($msg['from']['id'],'announce_usage'), [], $token); return; }
    doAnnounce($msg, $ann, $token);
}

// ══════════════════════════════════════════════════════════════
//  ENTRY POINT
// ══════════════════════════════════════════════════════════════
$isCli = PHP_SAPI === 'cli';

if ($isCli) {
    // CLI mode: long-polling
    $argv  = $_SERVER['argv'] ?? [];
    $runToken = BOT_TOKEN;
    for ($i = 1; $i < count($argv); $i++) {
        if ($argv[$i] === '--bot' && isset($argv[$i+1])) { $runToken = $argv[$i+1]; break; }
    }

    echo "[BOT] Starting with token: " . substr($runToken, 0, 10) . "...\n";

    // Start saved bots from main instance only
    if ($runToken === BOT_TOKEN) {
        $registry = loadRegistry();
        foreach ($registry as $tok => $info) {
            echo "[MAIN] Starting bot: " . substr($tok, 0, 15) . "...\n";
            spawnBot($tok, (int)($info['owner_id'] ?? 0));
        }
    }

    $offset = 0;
    while (true) {
        try {
            $ch = curl_init('https://api.telegram.org/bot' . $runToken . '/getUpdates?offset=' . $offset . '&timeout=30');
            curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_SSL_VERIFYPEER=>false, CURLOPT_TIMEOUT=>35]);
            $res  = curl_exec($ch); curl_close($ch);
            $data = json_decode($res, true);
            if (!$data || !$data['ok']) { sleep(5); continue; }
            foreach ($data['result'] as $update) {
                $offset = $update['update_id'] + 1;
                try { handleUpdate($update, $runToken); } catch (Throwable $e) { echo "[ERR] " . $e->getMessage() . "\n"; }
            }
        } catch (Throwable $e) {
            echo "[POLL ERR] " . $e->getMessage() . "\n";
            sleep(5);
        }
    }
} else {
    // Webhook mode
    $input  = file_get_contents('php://input');
    $update = json_decode($input, true);
    if ($update) {
        try { handleUpdate($update); } catch (Throwable $e) { error_log($e->getMessage()); }
    }
}
