<?php 
date_default_timezone_set('Europe/Moscow');
header('Content-Type: text/html; charset=utf-8');
$livecoinAllCurr = ['BTC/USD','BTC/EUR','BTC/RUR','LTC/BTC','LTC/USD','EMC/BTC','EMC/USD','EMC/RUR','EMC/ETH','EMC/DASH','EMC/XMR','DASH/BTC','DASH/USD','ETH/BTC','ETH/USD','ETH/RUR','STEEM/BTC','MAID/BTC','DOGE/BTC','DOGE/USD','CURE/BTC','SIB/BTC','SIB/RUR','TX/BTC','RBIES/BTC','ADZ/BTC','ADZ/USD','BSD/BTC','SXC/BTC','BTA/BTC','FST/BTC','FST/USD','VOX/BTC','MOJO/BTC','CRBIT/BTC','CRBIT/LEO','CRBIT/ETH','SHIFT/BTC','YOC/BTC','YOC/USD','YOC/RUR','CREVA/BTC','LSK/BTC','LSK/USD','EL/BTC','EL/USD','EL/RUR','EL/DANC','EL/ZBC','EL/UNRC','HNC/BTC','CLOAK/BTC','CLOAK/USD','CLOAK/EUR','MOIN/BTC','BLU/BTC','BLU/USD','LEO/BTC','LEO/USD','LEO/RUR','LEO/ETH','PPC/BTC','NMC/BTC','MONA/BTC','REE/BTC','REE/USD','REE/ETH','GAME/BTC','BLK/BTC','SYS/BTC','DGB/BTC','THS/BTC','THS/USD','THS/EUR','THS/RUR','THS/ETH','VRC/BTC','SLR/BTC','DBIX/BTC','XMR/BTC','XMR/USD','BTS/BTC','GB/BTC','VRM/BTC','VRM/VRC','ATX/BTC','ENT/BTC','BURST/BTC','NXT/BTC','POST/BTC','POST/ETH','EDR/BTC','EDR/USD','EDR/RUR','KRB/BTC','KRB/USD','KRB/RUR','ARC/BTC','ARC/USD','ARC/RUR','ARC/ETH','GYC/BTC','DMC/BTC','DMC/USD','VRS/BTC','VRS/USD','XRC/BTC','XRC/USD','BIT/BTC','DOLLAR/BTC','OD/BTC','XAUR/BTC','GOLOS/BTC','FRST/BTC','FRST/USD','FRST/ETH','UNC/BTC','VLTC/BTC','CCRB/BTC','CCRB/ETH','BPC/BTC','EUR/USD','USD/RUR','PRES/BTC','DIME/BTC','DIME/USD','DIME/EUR','DIME/RUR','DIME/ETH','ZBC/BTC','ZBC/USD','ZBC/EUR','ZBC/RUR','ZBC/ETH','ZBC/XMR','DIBC/BTC','DIBC/USD','DIBC/ETH','VSL/BTC','ICN/BTC','NVC/BTC','NVC/USD','XSPEC/BTC','ABN/BTC','BCC/BTC','BCC/USD','BCC/ETH','LUNA/BTC','ACN/BTC','LDC/BTC','MSCN/BTC','MSCN/USD','MSCN/EUR','MSCN/RUR','MSCN/ETH','POSW/BTC','POSW/USD','POSW/EUR','POSW/RUR','POSW/ETH','POSW/ICN','POSW/CRBIT','POSW/DASH','POSW/XMR','POSW/LTC','OBITS/BTC','OBITS/USD','OBITS/EUR','OBITS/BTS','OBITS/ETH','TIME/BTC','WAVES/BTC','DANC/BTC','DANC/USD','INCNT/BTC','TAAS/BTC','TAAS/USD','XMS/BTC','SOAR/BTC','SOAR/ETH','PIVX/BTC','PIVX/USD','PIVX/EUR','PIVX/RUR','PIVX/DASH','PIVX/XMR','PIVX/ETH','FUNC/BTC','FUNC/USD','FUNC/ETH','ITI/BTC','ITI/EUR','ITI/RUR','ITI/ETH','PUT/BTC','PUT/USD','PUT/RUR','PUT/ETH','GUP/BTC','GUP/ETH','MNE/BTC','MNE/ETH','WINGS/BTC','WINGS/ETH','UNRC/BTC','UNRC/USD','RLT/BTC','RLT/USD','RLT/RUR','RLT/ETH','UNY/BTC','UNY/USD','UNY/ETH','UNY/LTC','FORTYTWO/BTC','FORTYTWO/USD','FORTYTWO/ETH','STRAT/BTC','STRAT/USD','STRAT/ETH','INSN/BTC','INSN/USD','INSN/ETH','QAU/BTC','QAU/USD','QAU/ETH','TRUMP/BTC','TRUMP/ETH','FNC/BTC','FNC/ETH','FNC/USD','MCO/BTC','MCO/USD','MCO/ETH','VOISE/BTC','VOISE/USD','VOISE/EUR','VOISE/ETH','PPY/BTC','PPY/USD','PPY/ETH','ASAFE2/BTC','ASAFE2/USD','PLBT/BTC','PLBT/ETH','PLBT/USD','KPL/BTC','KPL/USD','KPL/ETH','BCH/BTC','BCH/USD','BCH/RUR','BCH/ETH','BCH/ZBC','MCR/BTC','MCR/ETH','PIPL/BTC','PIPL/ETH','HVN/BTC','HVN/USD','HVN/ETH','XRL/BTC','XRL/ETH','MGO/BTC','MGO/ETH','FU/BTC','FU/ETH','WIC/BTC','WIC/ETH','CTR/BTC','CTR/USD','CTR/ETH','GRS/BTC','GRS/USD','GRS/ETH','PRO/BTC','PRO/USD','PRO/ETH','XEM/BTC','XEM/USD','XEM/ETH','CPC/BTC','CPC/USD','CPC/ETH','wETT/BTC','wETT/USD','wETT/ETH','eETT/BTC','eETT/USD','eETT/ETH','SUMO/BTC','SUMO/USD','SUMO/ETH','QTUM/BTC','QTUM/USD','QTUM/ETH','OMG/BTC','OMG/USD','OMG/ETH','PAY/BTC','PAY/USD','PAY/ETH','KNC/BTC','KNC/USD','KNC/ETH','GNT/BTC','GNT/USD','GNT/ETH','EOS/BTC','EOS/USD','EOS/ETH','BAT/BTC','BAT/USD','BAT/ETH','REP/BTC','REP/USD','REP/ETH','MTL/BTC','MTL/USD','MTL/ETH','DGD/BTC','DGD/USD','DGD/ETH','CVC/BTC','CVC/USD','CVC/ETH','SNGLS/BTC','SNGLS/USD','SNGLS/ETH','SNT/BTC','SNT/USD','SNT/ETH','GNO/BTC','GNO/USD','GNO/ETH','ZRX/BTC','ZRX/USD','ZRX/ETH','BNT/BTC','BNT/USD','BNT/ETH','FUN/BTC','FUN/USD','FUN/ETH','EDG/BTC','EDG/USD','EDG/ETH','ANT/BTC','ANT/USD','ANT/ETH','BQX/BTC','BQX/USD','BQX/ETH','STORJ/BTC','STORJ/USD','STORJ/ETH','RLC/BTC','RLC/USD','RLC/ETH','TKN/BTC','TKN/USD','TKN/ETH','MLN/BTC','MLN/USD','MLN/ETH','TRST/BTC','TRST/USD','TRST/ETH','FirstBlood/BTC','FirstBlood/USD','FirstBlood/ETH','VIB/BTC','VIB/USD','VIB/ETH','MTCoin/BTC','MTCoin/USD','MTCoin/ETH','BIO/BTC','BIO/ETH','BIO/RUR','BIO/USD','NEO/BTC','NEO/USD','NEO/ETH','OTN/BTC','OTN/ETH','MNX/BTC','MNX/ETH','ENJ/BTC','ENJ/ETH','DAY/BTC','DAY/ETH'];
$bitfinexAllCurr = ['btcusd','ltcusd','ltcbtc','ethusd','ethbtc','etcbtc','etcusd','rrtusd','rrtbtc','zecusd','zecbtc','xmrusd','xmrbtc','dshusd','dshbtc','bccbtc','bcubtc','bccusd','bcuusd','xrpusd','xrpbtc','iotusd','iotbtc','ioteth','eosusd','eosbtc','eoseth','sanusd','sanbtc','saneth','omgusd','omgbtc','omgeth','bchusd','bchbtc','bcheth','neousd','neobtc','neoeth','etpusd','etpbtc','etpeth','qtmusd','qtmbtc','qtmeth','bt1usd','bt2usd','bt1btc','bt2btc','avtusd','avtbtc','avteth','edousd','edobtc','edoeth','btgusd','btgbtc'];
$bittrexAllCurr = ['BTC-LTC','BTC-DOGE','BTC-VTC','BTC-PPC','BTC-FTC','BTC-RDD','BTC-NXT','BTC-DASH','BTC-POT','BTC-BLK','BTC-EMC2','BTC-XMY','BTC-AUR','BTC-EFL','BTC-GLD','BTC-SLR','BTC-PTC','BTC-GRS','BTC-NLG','BTC-RBY','BTC-XWC','BTC-MONA','BTC-THC','BTC-ENRG','BTC-ERC','BTC-VRC','BTC-CURE','BTC-XMR','BTC-CLOAK','BTC-START','BTC-KORE','BTC-XDN','BTC-TRUST','BTC-NAV','BTC-XST','BTC-BTCD','BTC-VIA','BTC-PINK','BTC-IOC','BTC-CANN','BTC-SYS','BTC-NEOS','BTC-DGB','BTC-BURST','BTC-EXCL','BTC-SWIFT','BTC-DOPE','BTC-BLOCK','BTC-ABY','BTC-BYC','BTC-XMG','BTC-BLITZ','BTC-BAY','BTC-BTS','BTC-FAIR','BTC-SPR','BTC-VTR','BTC-XRP','BTC-GAME','BTC-COVAL','BTC-NXS','BTC-XCP','BTC-BITB','BTC-GEO','BTC-FLDC','BTC-GRC','BTC-FLO','BTC-NBT','BTC-MUE','BTC-XEM','BTC-CLAM','BTC-DMD','BTC-GAM','BTC-SPHR','BTC-OK','BTC-SNRG','BTC-PKB','BTC-CPC','BTC-AEON','BTC-ETH','BTC-GCR','BTC-TX','BTC-BCY','BTC-EXP','BTC-INFX','BTC-OMNI','BTC-AMP','BTC-AGRS','BTC-XLM','USDT-BTC','BTC-CLUB','BTC-VOX','BTC-EMC','BTC-FCT','BTC-MAID','BTC-EGC','BTC-SLS','BTC-RADS','BTC-DCR','BTC-SAFEX','BTC-BSD','BTC-XVG','BTC-PIVX','BTC-XVC','BTC-MEME','BTC-STEEM','BTC-2GIVE','BTC-LSK','BTC-PDC','BTC-BRK','BTC-DGD','ETH-DGD','BTC-WAVES','BTC-RISE','BTC-LBC','BTC-SBD','BTC-BRX','BTC-ETC','ETH-ETC','BTC-STRAT','BTC-UNB','BTC-SYNX','BTC-TRIG','BTC-EBST','BTC-VRM','BTC-SEQ','BTC-XAUR','BTC-SNGLS','BTC-REP','BTC-SHIFT','BTC-ARDR','BTC-XZC','BTC-NEO','BTC-ZEC','BTC-ZCL','BTC-IOP','BTC-GOLOS','BTC-UBQ','BTC-KMD','BTC-GBG','BTC-SIB','BTC-ION','BTC-LMC','BTC-QWARK','BTC-CRW','BTC-SWT','BTC-TIME','BTC-MLN','BTC-ARK','BTC-DYN','BTC-TKS','BTC-MUSIC','BTC-DTB','BTC-INCNT','BTC-GBYTE','BTC-GNT','BTC-NXC','BTC-EDG','BTC-LGD','BTC-TRST','ETH-GNT','ETH-REP','USDT-ETH','ETH-WINGS','BTC-WINGS','BTC-RLC','BTC-GNO','BTC-GUP','BTC-LUN','ETH-GUP','ETH-RLC','ETH-LUN','ETH-SNGLS','ETH-GNO','BTC-APX','BTC-TKN','ETH-TKN','BTC-HMQ','ETH-HMQ','BTC-ANT','ETH-TRST','ETH-ANT','BTC-SC','ETH-BAT','BTC-BAT','BTC-ZEN','BTC-1ST','BTC-QRL','ETH-1ST','ETH-QRL','BTC-CRB','ETH-CRB','ETH-LGD','BTC-PTOY','ETH-PTOY','BTC-MYST','ETH-MYST','BTC-CFI','ETH-CFI','BTC-BNT','ETH-BNT','BTC-NMR','ETH-NMR','ETH-TIME','ETH-LTC','ETH-XRP','BTC-SNT','ETH-SNT','BTC-DCT','BTC-XEL','BTC-MCO','ETH-MCO','BTC-ADT','ETH-ADT','BTC-FUN','ETH-FUN','BTC-PAY','ETH-PAY','BTC-MTL','ETH-MTL','BTC-STORJ','ETH-STORJ','BTC-ADX','ETH-ADX','ETH-DASH','ETH-SC','ETH-ZEC','USDT-ZEC','USDT-LTC','USDT-ETC','USDT-XRP','BTC-OMG','ETH-OMG','BTC-CVC','ETH-CVC','BTC-PART','BTC-QTUM','ETH-QTUM','ETH-XMR','ETH-XEM','ETH-XLM','ETH-NEO','USDT-XMR','USDT-DASH','ETH-BCC','USDT-BCC','BTC-BCC','BTC-DNT','ETH-DNT','USDT-NEO','ETH-WAVES','ETH-STRAT','ETH-DGB','ETH-FCT','ETH-BTS','USDT-OMG','BTC-ADA','BTC-MANA','ETH-MANA','BTC-SALT','ETH-SALT','BTC-TIX','ETH-TIX'];
$exmoAllCurr = ['BTC_USD','BTC_EUR','BTC_RUB','BTC_UAH','DASH_BTC','DASH_USD','DASH_RUB','ETH_BTC','ETH_LTC','ETH_USD','ETH_EUR','ETH_RUB','ETH_UAH','ETC_BTC','ETC_USD','ETC_RUB','LTC_BTC','LTC_USD','LTC_EUR','LTC_RUB','ZEC_BTC','ZEC_USD','ZEC_EUR','ZEC_RUB','XRP_BTC','XRP_USD','XRP_RUB','XMR_BTC','XMR_USD','XMR_EUR','BTC_USDT','ETH_USDT','USDT_USD','USDT_RUB','USD_RUB','DOGE_BTC','WAVES_BTC','WAVES_RUB','KICK_BTC','KICK_ETH'];
$poloniexAllCurr = ['BTC_BCN','BTC_BELA','BTC_BLK','BTC_BTCD','BTC_BTM','BTC_BTS','BTC_BURST','BTC_CLAM','BTC_DASH','BTC_DGB','BTC_DOGE','BTC_EMC2','BTC_FLDC','BTC_FLO','BTC_GAME','BTC_GRC','BTC_HUC','BTC_LTC','BTC_MAID','BTC_OMNI','BTC_NAUT','BTC_NAV','BTC_NEOS','BTC_NMC','BTC_NOTE','BTC_NXT','BTC_PINK','BTC_POT','BTC_PPC','BTC_RIC','BTC_SJCX','BTC_STR','BTC_SYS','BTC_VIA','BTC_XVC','BTC_VRC','BTC_VTC','BTC_XBC','BTC_XCP','BTC_XEM','BTC_XMR','BTC_XPM','BTC_XRP','USDT_BTC','USDT_DASH','USDT_LTC','USDT_NXT','USDT_STR','USDT_XMR','USDT_XRP','XMR_BCN','XMR_BLK','XMR_BTCD','XMR_DASH','XMR_LTC','XMR_MAID','XMR_NXT','BTC_ETH','USDT_ETH','BTC_SC','BTC_BCY','BTC_EXP','BTC_FCT','BTC_RADS','BTC_AMP','BTC_DCR','BTC_LSK','ETH_LSK','BTC_LBC','BTC_STEEM','ETH_STEEM','BTC_SBD','BTC_ETC','ETH_ETC','USDT_ETC','BTC_REP','USDT_REP','ETH_REP','BTC_ARDR','BTC_ZEC','ETH_ZEC','USDT_ZEC','XMR_ZEC','BTC_STRAT','BTC_NXC','BTC_PASC','BTC_GNT','ETH_GNT','BTC_GNO','ETH_GNO','BTC_BCH','ETH_BCH','USDT_BCH','BTC_ZRX','ETH_ZRX','BTC_CVC','ETH_CVC','BTC_OMG','ETH_OMG','BTC_GAS','ETH_GAS','BTC_STORJ'];
$BTCCurr = ['YOVI/BTC','ETH/BTC','DASH/BTC','WAVES/BTC','ZEC/BTC','LSK/BTC','BCC/BTC','LTC/BTC','REC/BTC','ATB/BTC','DFT/BTC','BTG/BTC','FRST/BTC','DOGE/BTC','ONX/BTC','NLC2/BTC','XIOS/BTC','LTCU/BTC','CNX/BTC','MVC/BTC','ZUR/BTC','ARCX/BTC','BGF/BTC','XBY/BTC','SW/BTC','CNT/BTC','BUZZ/BTC','VTC/BTC','COMP/BTC','HAC/BTC','DGB/BTC','TPG/BTC','ETC/BTC','HPC/BTC','VISIO/BTC','SIGT/BTC','HTML5/BTC','XEM/BTC','OMG/BTC','AGT/BTC','SYS/BTC','ALTCOM/BTC','NET/BTC','ONEK/BTC','ZENI/BTC','PIVX/BTC','BTCR/BTC','XVG/BTC','F16/BTC','RDD/BTC','SWT/BTC','BTS/BTC','HMC/BTC','SNM/BTC','MAPC/BTC','PLBT/BTC','DCR/BTC','SIB/BTC','TAM/BTC','PAY/BTC','POSW/BTC','WOMEN/BTC','B3/BTC','WHO/BTC','SLS/BTC','GER/BTC','GNT/BTC','RUP/BTC','MAO/BTC','WBB/BTC','MPRO/BTC','KICK/BTC','ANI/BTC','MAX/BTC','PUTIN/BTC','XDE/BTC','SCL/BTC','BOLI/BTC','MINH/BTC','ADZ/BTC','EDR2/BTC','XHI/BTC','SAN/BTC','EXT/BTC','ANT/BTC','GCR/BTC','VIA/BTC','POST/BTC','AMS/BTC','MAY/BTC','BUY/BTC','GAME/BTC','LEA/BTC','LINDA/BTC','BUCKS/BTC','CWXT/BTC','DCT/BTC','AXIOM/BTC','IVZ/BTC','ZNE/BTC','RBY/BTC','ELITE/BTC','ZONTO/BTC','ATM/BTC','TIT/BTC','INPAY/BTC','LTD/BTC','NVC/BTC','CANN/BTC','BCM/BTC','BAT/BTC','TRUMP/BTC','MXT/BTC','EVIL/BTC','PING/BTC','KNC/BTC','START/BTC','HTC/BTC','RISE/BTC','KR/BTC','PIO/BTC','NMR/BTC','MARX/BTC','TOKC/BTC','XLTCG/BTC','RPC/BTC','VK/BTC','PAK/BTC','MONEY/BTC','VPN/BTC','UNI/BTC','HALLO/BTC','GTFO/BTC','NYC/BTC','GP/BTC','MGO/BTC','INC/BTC','CRM/BTC','SKULL/BTC','LANA/BTC','VLT/BTC','ZLQ/BTC','EGO/BTC','LVG/BTC','STO/BTC','CRAVE/BTC','GCC/BTC','AUR/BTC','ARCO/BTC','SPR/BTC','VOYA/BTC','CONX/BTC','ALIS/BTC','MERGEC/BTC','TMRW/BTC','ENT/BTC','AV/BTC','SUB/BTC','IMPS/BTC','IXT/BTC','WIC/BTC','XNG/BTC','PPC/BTC','XMG/BTC','BITB/BTC','ROCKET/BTC','MCO/BTC','TAG/BTC','ICON/BTC','ICASH/BTC','NMC/BTC','DBIC/BTC','UNIFY/BTC','GNO/BTC','BOD/BTC','XPTX/BTC','KOBO/BTC','TIDE/BTC','SED/BTC','LRC/BTC','OK/BTC','TX/BTC','DUX/BTC','KARMA/BTC','XMS/BTC','MDT/BTC','CLUB/BTC','LBTC/BTC','GPU/BTC','NETKO/BTC','RUBIT/BTC','LDOGE/BTC','DGCS/BTC','CRW/BTC','XVS/BTC','LKC/BTC','UBIQ/BTC','VOLT/BTC','HZT/BTC','BITS/BTC','MUE/BTC','GFL/BTC','BLU/BTC','LTCR/BTC','STORJ/BTC','YES/BTC','ECOB/BTC','AIB/BTC','ANTI/BTC','UDOWN/BTC','CROC/BTC','MOJO/BTC','NANOX/BTC','700/BTC','CBX/BTC','BHC/BTC','ZYD/BTC','MVR/BTC','BCS/BTC','PIE/BTC','2BACCO/BTC','ESP/BTC','DLC/BTC','STP/BTC','SPT/BTC','INSANE/BTC','TLE/BTC','RICHX/BTC','GELD/BTC','DRA/BTC','BNT/BTC','PLU/BTC','AST/BTC','XQN/BTC','TAJ/BTC','HXX/BTC','MILO/BTC','ALTC/BTC','DIME/BTC','MOTO/BTC','ABY/BTC','ZRC/BTC','XGTC/BTC','GB/BTC','ATMCHA/BTC','XPD/BTC','RSGP/BTC','CXT/BTC','MST/BTC','GSR/BTC','EVO/BTC','DROP/BTC','CJC/BTC','FIT/BTC','CTIC2/BTC','CREVA/BTC','CME/BTC','OLIT/BTC','DCK/BTC','NKA/BTC','PHR/BTC','CTL/BTC','DGMS/BTC','KGC/BTC','DEM/BTC','ALC/BTC','MOOND/BTC','BRAIN/BTC','WOK/BTC','GEN/BTC','EA/BTC','CST/BTC','CCC/BTC','VULC/BTC','ECO/BTC','VTL/BTC','USC/BTC','2GIVE/BTC','NEVA/BTC','ZET/BTC','XIN/BTC','STONK/BTC','CPC/BTC','GE/BTC','LAZ/BTC','DRKT/BTC','EMB/BTC','BSTY/BTC','PARTY/BTC','SOCC/BTC','EGC/BTC','TEK/BTC','ZEIT/BTC','LENIN/BTC','EMP/BTC','SMC/BTC','XBTC21/BTC','BUB/BTC','MCRN/BTC','C0C0/BTC','PRIMU/BTC','WINK/BTC','FLY/BTC','ETHS/BTC','BTP/BTC','BXT/BTC','CLAM/BTC','PX/BTC','PLNC/BTC','XPC/BTC','CCT/BTC','DGD/BTC','32BIT/BTC','BPC/BTC','CMT/BTC','BPOK/BTC','CJ/BTC','TOKEN/BTC','CLOAK/BTC','URC/BTC','ALEX/BTC','SWING/BTC','ATOM/BTC','SPX/BTC','GOT/BTC','BTA/BTC','STRP/BTC','MAZE/BTC','RUPX/BTC','XRA/BTC','SPKTR/BTC','PXI/BTC','LTS/BTC','HOPE/BTC','RIDE/BTC','CAB/BTC','CYC/BTC','EUC/BTC','ARTA/BTC','CAID/BTC','GEO/BTC','BTCU/BTC','NANAS/BTC','BTZ/BTC','XBU/BTC','FRK/BTC','SIC/BTC','IXC/BTC','DGORE/BTC','FFC/BTC','AIR/BTC','X2/BTC','CC/BTC','BRONZ/BTC','ACES/BTC','ACLR/BTC','BENJI/BTC','SPORT/BTC','PRE/BTC','ZMC/BTC','JOBS/BTC','PWR/BTC','BLRY/BTC','HMQ/BTC','YAY/BTC','UNIT/BTC','BNB/BTC','TRON/BTC','ELC/BTC','SXC/BTC','NZC/BTC','XUP/BTC','REP/BTC','DOGETH/BTC','EMC/BTC','ODNT/BTC','PARA/BTC','DPAY/BTC','CTK/BTC','HON/BTC','LIR/BTC','YBC/BTC','CV2/BTC','HAMS/BTC','BTCRY/BTC','XNX/BTC','XSSX/BTC','DASHS/BTC','NOO/BTC','XCO/BTC','EBONUS/BTC','RCN/BTC','MM/BTC','KGB/BTC','BVC/BTC','WRT/BTC','OP/BTC','MONETA/BTC','DUST/BTC','EOS/BTC','KAT/BTC','DBTC/BTC','MTLMC3/BTC','CHILL/BTC','JNT/BTC','CCB/BTC','TOT/BTC','LITE/BTC','GRF/BTC','BLAZR/BTC','TELL/BTC','SKB/BTC','MBIT/BTC','FIRE/BTC','LUNYR/BTC','TEAM/BTC','SSTC/BTC','MRP/BTC','BST/BTC','BTD/BTC','STV/BTC','PSB/BTC','STA/BTC','GRAM/BTC','NTRN/BTC','APT/BTC','FONZ/BTC','CLINT/BTC','GSY/BTC','LUNA/BTC','CG/BTC','VIDZ/BTC','CD/BTC','CORAL/BTC','RID/BTC','TNT/BTC','N7/BTC','SEN/BTC','FAZZ/BTC','LUCKY/BTC','ELE/BTC','BSTK/BTC','SBIT/BTC','BOSS/BTC','DISK/BTC','NODES/BTC','FOREX/BTC','U/BTC','METAL/BTC','COXST/BTC','GIG/BTC','YAC/BTC','OPAL/BTC','JWL/BTC','TRA/BTC','ARGUS/BTC','MLITE/BTC','NUM/BTC','TB/BTC','FIDGT/BTC','EQUAL/BTC','TLOSH/BTC','USDE/BTC','TKN/BTC','GREXIT/BTC','GIZ/BTC','1337/BTC','SAK/BTC','BIT16/BTC','CBD/BTC','MCAR/BTC','CMC/BTC','vSlice/BTC','VIP/BTC','TCR/BTC','KARMC/BTC','TIA/BTC','ICOB/BTC','CRX/BTC','PKB/BTC','BASH/BTC','NUBIS/BTC','LUN/BTC','ARE/BTC','COC/BTC','ZECD/BTC','GHS/BTC','TDFB/BTC','ACPR/BTC','420G/BTC','TOOL/BTC','ICN/BTC','RBT/BTC','NKC/BTC','YMC/BTC','VTX/BTC','TNG/BTC','CS/BTC','BSC/BTC','KISS/BTC','VCOIN/BTC','HODL/BTC','MIS/BTC','ECLI/BTC','NODC/BTC','PNK/BTC','XPRO/BTC','BIOB/BTC','NETC/BTC','IMS/BTC','DOX/BTC','SYNX/BTC','SCAN/BTC','CIRC/BTC','NKT/BTC','STS/BTC','LGBTQ/BTC','AMBER/BTC','EMPC/BTC','RADI/BTC','FRE/BTC','FIND/BTC','888/BTC','PROFIT/BTC','FCASH/BTC','JOCKER/BTC','HSP/BTC','CYG/BTC','FPC/BTC','CLUD/BTC','FRWC/BTC','ADT/BTC','BTTF/BTC','ZET2/BTC','PURE/BTC','SDC/BTC','SBT/BTC','RAD/BTC','AL/BTC','NTM/BTC','LOOT/BTC','EDIT/BTC','VOL/BTC','SUPER/BTC','MNM/BTC','DBLK/BTC','DB/BTC','CORG/BTC','SCS/BTC','NXE/BTC','PAL/BTC','EKO/BTC','POPPY/BTC','SNRG/BTC','PLANET/BTC','MAVRO/BTC','URO/BTC','KC/BTC','OBS/BTC','CNNC/BTC','365/BTC','FGZ/BTC','CZECO/BTC','NOTE/BTC','TSE/BTC','WCASH/BTC','OS76/BTC','CF/BTC','L7S/BTC','SHORTY/BTC','SMBR/BTC','VERS/BTC','NRC/BTC','GRE/BTC','DCYP/BTC','HYPERX/BTC','GBIT/BTC','ADCN/BTC','NPC/BTC','HAZE/BTC','GROW/BTC','SEL/BTC','TODAY/BTC','CFC/BTC','BON/BTC','MAD/BTC','EGAME/BTC','MUU/BTC','LEAF/BTC','PAC/BTC','SLFI/BTC','EQT/BTC','MMXVI/BTC','IOC/BTC','ELCO/BTC','POLY/BTC','KIDS/BTC','CRPS/BTC','GENE/BTC','MOIN/BTC','C2/BTC','GREED/BTC','EXB/BTC','PROC/BTC','DEA/BTC','BLUS/BTC','BAM/BTC','MENTAL/BTC','GMCX/BTC','CKS/BTC','SJW/BTC','SHRP/BTC','KUSH/BTC','TAGR/BTC','FADE/BTC','NUKE/BTC','GENIUS/BTC','BEST/BTC','XVE/BTC','TAKE/BTC','PSY/BTC','ECN/BTC','SLCO/BTC','XNM/BTC','SPEC/BTC','VNTX/BTC','WEEK/BTC','OPTION/BTC','BITOK/BTC','FJC/BTC','FIST/BTC','ALIEN/BTC','CTIC/BTC','BATL/BTC','PIPR/BTC','GREENF/BTC','MAT/BTC','TCN/BTC','WITCH/BTC','LUMI/BTC','XCE/BTC','EOC/BTC','TRANSF/BTC','KASHH/BTC','TAP/BTC','XPS/BTC','HEDG/BTC','NODX/BTC','ARPA/BTC','SEEDS/BTC','SMSR/BTC','XTR/BTC','GLUCK/BTC','VEC2/BTC','BAB/BTC','FURY/BTC','ILM/BTC','PUPA/BTC','EVA/BTC','DUB/BTC','VAPOR/BTC','GLO/BTC','TENNET/BTC','VTN/BTC','TEC/BTC','ANAL/BTC','ZIRK/BTC','XDB/BTC','NDOGE/BTC','TAB/BTC','AECC/BTC','PXL/BTC','BITZ/BTC','PTY/BTC','LDM/BTC','TWIST/BTC','XAU/BTC','256/BTC','GIFT/BTC','P7C/BTC','EGG/BTC','POM/BTC','8BIT/BTC','TP1/BTC','ETRUST/BTC','TIME/BTC','TRICK/BTC','BBCC/BTC','CRY/BTC','TCX/BTC','CYP/BTC','GSM/BTC','GUP/BTC','PND/BTC','TES/BTC','XSP/BTC','CON/BTC','OZC/BTC','DLISK/BTC','EAGS/BTC','NAV/BTC','GSX/BTC','CAM/BTC','ETCO/BTC','GML/BTC','XPY/BTC','STK/BTC','2015/BTC','KTK/BTC','OMA/BTC','PEN/BTC','CRIME/BTC','BOOM/BTC','RICE/BTC','SOMA/BTC','EXP/BTC','DES/BTC','AM/BTC','XBS/BTC','DECR/BTC','IND/BTC','DLT/BTC','BA/BTC','KRAK/BTC','DXO/BTC','MRB/BTC','PTA/BTC','ESC/BTC','FIDEL/BTC','DUR/BTC','FSN/BTC','DOTA/BTC','SHELL/BTC','INGT/BTC','M1/BTC','DCC/BTC','ARB/BTC','ACRN/BTC','EUROPE/BTC','OCEAN/BTC','SOLAR/BTC','RBBT/BTC','NICE/BTC','CDO/BTC','RH/BTC','WAM/BTC','MULTI/BTC','TWERK/BTC','EQM/BTC','ADAM/BTC','ERR/BTC','WGR/BTC','QTZ/BTC','WGO/BTC','GUM/BTC','SHDW/BTC','SIGU/BTC','RUC/BTC','COV/BTC','IFT/BTC','LUX/BTC','DRZ/BTC','007/BTC','AGRI/BTC','GRAV/BTC','BBH/BTC','PLAY/BTC','FUNK/BTC','VRP/BTC','CIN/BTC','ISL/BTC','UTLE/BTC','RAI/BTC','SLEEP/BTC','EPY/BTC','GOAT/BTC','PNC/BTC','QTM/BTC','JOK/BTC','SFE/BTC','INV/BTC','VPRC/BTC','COIN/BTC','XMT/BTC','GLC/BTC','HCC/BTC','DUO/BTC','STAR/BTC','KUBO/BTC','DBG/BTC','FLVR/BTC','BTCO/BTC','REE/BTC','GO/BTC','PONZ2/BTC','SPM/BTC','VEG/BTC','WMC/BTC','RNC/BTC','JPC/BTC','UAE/BTC','BDC/BTC','UIS/BTC','IONX/BTC','B2/BTC','XSY/BTC','PRM/BTC','LIMX/BTC','INCP/BTC','HVCO/BTC','RMS/BTC','EPC/BTC','ADC/BTC','CHEMX/BTC','NIC/BTC','MARV/BTC','BSH/BTC','CB/BTC','RONIN/BTC','SCRPT/BTC','FUZZ/BTC','GT/BTC','VENE/BTC','CHESS/BTC','CSMIC/BTC','404/BTC','SHREK/BTC','FLX/BTC','ECCHI/BTC','DEC/BTC','EXIT/BTC','COX/BTC','TALK/BTC','CUBE/BTC','ENTER/BTC','RIO/BTC','SP/BTC','SLING/BTC','SOUL/BTC','RATIO/BTC','DRM/BTC','DRACO/BTC','HAWK/BTC','TBCX/BTC','PULSE/BTC','PCM/BTC','ENE/BTC','SONG/BTC','XAV/BTC','DXC/BTC','BILL/BTC','JACK/BTC','WARP/BTC','EDRC/BTC','UNF/BTC','PAYP/BTC','SIX/BTC','BIGUP/BTC','SPEX/BTC','PEX/BTC','RBIES/BTC','CREDIT/BTC','HIRE/BTC','VAL/BTC','HMP/BTC','BRDD/BTC','BERN/BTC','EURC/BTC','XJO/BTC','FRN/BTC','GBT/BTC','PONZI/BTC','DC/BTC','RCX/BTC','CHRG/BTC','GOTX/BTC','EDC/BTC','LOC/BTC','CARBON/BTC','OCOW/BTC','LTH/BTC','QBC/BTC','ACOIN/BTC','TECH/BTC','TAK/BTC','BITON/BTC','XDE2/BTC','STRB/BTC','ORLY/BTC','JIF/BTC','NLG/BTC','PINKX/BTC','OPES/BTC','ACID/BTC','TRAP/BTC','SSC/BTC','BOMB/BTC','MND/BTC','BAC/BTC','IBANK/BTC','ARTC/BTC','JANE/BTC','IN/BTC','LOOK/BTC','BSTAR/BTC','ARH/BTC','PEO/BTC','ZOOM/BTC','BEEZ/BTC','LEPEN/BTC','SQL/BTC','SMF/BTC','XFCX/BTC','SOLO/BTC','TTC/BTC','DETH/BTC','XCRE/BTC','LSD/BTC','SDP/BTC','UXC/BTC','NBIT/BTC','LIV/BTC','IFLT/BTC','DIRT/BTC','AUM/BTC','SCASH/BTC','KURT/BTC','BOSON/BTC','IW/BTC','MYSTIC/BTC','PRX/BTC','NIXON/BTC','NEBU/BTC','ASN/BTC','IBITS/BTC','TLEX/BTC','MLNC/BTC','WEALTH/BTC','SHRM/BTC','THOM/BTC','ITI/BTC','SEV/BTC','MCOIN/BTC','ALL/BTC','NOC/BTC','BIOS/BTC','CURVES/BTC','LIZI/BTC','WISC/BTC','NEF/BTC','ROS/BTC','HIFUN/BTC','ACP/BTC','CAPT/BTC','STALIN/BTC','IEC/BTC','CHIP/BTC','CHAT/BTC','UNITS/BTC','SPC/BTC','ASAFE/BTC','RBIT/BTC','CRNK/BTC','CYT/BTC','SH/BTC','WAY/BTC','INFX/BTC','CCX/BTC','XOC/BTC','PSI/BTC','VTY/BTC','STHR/BTC','BOT/BTC','FX/BTC','SCITW/BTC','LC/BTC','STEPS/BTC','RUST/BTC','SWEET/BTC','CRAFT/BTC','XT/BTC','BAN/BTC','DTT/BTC','POKE/BTC','GAKH/BTC','SCT/BTC','OLYMP/BTC','FRDC/BTC','GOON/BTC','GAIN/BTC','BRE/BTC','SRND/BTC','CRAB/BTC','CHOOF/BTC','BS/BTC','LHC/BTC','N2O/BTC','CLICK/BTC','ROYAL/BTC','DKC/BTC','BEEP/BTC','WASH/BTC','HEEL/BTC','JW/BTC','WINE/BTC','POWER/BTC','XPO/BTC','XMINE/BTC','TUR/BTC','VEC/BTC','NAT/BTC','SPACE/BTC','TAO/BTC','SCRT/BTC','RING/BTC','XBTS/BTC','DCRE/BTC','OMC/BTC','TWO/BTC','ARM/BTC','SANDG'];


$liveCoinFinalArr = ['ETH/BTC'=>'ETH/BTC','LTC/BTC'=>'LTC/BTC','DASH/BTC'=>'DASH/BTC','XMR/BTC'=>'XMR/BTC','BCH/BTC'=>'BCH/BTC','LSK/BTC'=>'LSK/BTC','DGB/BTC'=>'DGB/BTC','STRAT/BTC'=>'STRAT/BTC','OMG/BTC'=>'OMG/BTC','BTS/BTC'=>'BTS/BTC','XEM/BTC'=>'XEM/BTC','DOGE/BTC'=>'DOGE/BTC','GAME/BTC'=>'GAME/BTC','MAID/BTC'=>'MAID/BTC','SYS/BTC'=>'SYS/BTC','NXT/BTC'=>'NXT/BTC','CVC/BTC'=>'CVC/BTC','GNT/BTC'=>'GNT/BTC','GNO/BTC'=>'GNO/BTC','ZRX/BTC'=>'ZRX/BTC','STEEM/BTC'=>'STEEM/BTC','REP/BTC'=>'REP/BTC','BURST/BTC'=>'BURST/BTC','BLK/BTC'=>'BLK/BTC','VRC/BTC'=>'VRC/BTC','NMC/BTC'=>'NMC/BTC','PPC/BTC'=>'PPC/BTC'];
$bitfinexFinalArr = ['ETH/BTC'=>'ethbtc','XRP/BTC'=>'xrpbtc','LTC/BTC'=>'ltcbtc','XMR/BTC'=>'xmrbtc','BCH/BTC'=>'bchbtc','ZEC/BTC'=>'zecbtc','ETC/BTC'=>'etcbtc','OMG/BTC'=>'omgbtc'];
$bittrexFinalArr = ['ETH/BTC'=>'BTC-ETH','XRP/BTC'=>'BTC-XRP','LTC/BTC'=>'BTC-LTC','DASH/BTC'=>'BTC-DASH','XMR/BTC'=>'BTC-XMR','VTC/BTC'=>'BTC-VTC','LSK/BTC'=>'BTC-LSK','ZEC/BTC'=>'BTC-ZEC','DGB/BTC'=>'BTC-DGB','STRAT/BTC'=>'BTC-STRAT','ETC/BTC'=>'BTC-ETC','OMG/BTC'=>'BTC-OMG','BTS/BTC'=>'BTC-BTS','EMC2/BTC'=>'BTC-EMC2','XEM/BTC'=>'BTC-XEM','FCT/BTC'=>'BTC-FCT','DOGE/BTC'=>'BTC-DOGE','GAME/BTC'=>'BTC-GAME','SC/BTC'=>'BTC-SC','XVC/BTC'=>'BTC-XVC','CLAM/BTC'=>'BTC-CLAM','MAID/BTC'=>'BTC-MAID','SYS/BTC'=>'BTC-SYS','POT/BTC'=>'BTC-POT','NXT/BTC'=>'BTC-NXT','NAV/BTC'=>'BTC-NAV','CVC/BTC'=>'BTC-CVC','GNT/BTC'=>'BTC-GNT','VIA/BTC'=>'BTC-VIA','GNO/BTC'=>'BTC-GNO','DCR/BTC'=>'BTC-DCR','STEEM/BTC'=>'BTC-STEEM','REP/BTC'=>'BTC-REP','ARDR/BTC'=>'BTC-ARDR','NEOS/BTC'=>'BTC-NEOS','BURST/BTC'=>'BTC-BURST','OMNI/BTC'=>'BTC-OMNI','LBC/BTC'=>'BTC-LBC','EXP/BTC'=>'BTC-EXP','FLO/BTC'=>'BTC-FLO','AMP/BTC'=>'BTC-AMP','XCP/BTC'=>'BTC-XCP','NXC/BTC'=>'BTC-NXC','FLDC/BTC'=>'BTC-FLDC','BLK/BTC'=>'BTC-BLK','PINK/BTC'=>'BTC-PINK','GRC/BTC'=>'BTC-GRC','RADS/BTC'=>'BTC-RADS','VRC/BTC'=>'BTC-VRC','SBD/BTC'=>'BTC-SBD','PPC/BTC'=>'BTC-PPC','BTCD/BTC'=>'BTC-BTCD','BCY/BTC'=>'BTC-BCY'];
$exmoFinalArr = ['ETH/BTC'=>'ETH_BTC','XRP/BTC'=>'XRP_BTC','LTC/BTC'=>'LTC_BTC','DASH/BTC'=>'DASH_BTC','XMR/BTC'=>'XMR_BTC','ZEC/BTC'=>'ZEC_BTC','ETC/BTC'=>'ETC_BTC','DOGE/BTC'=>'DOGE_BTC'];
$poloniexFinalArr = ['ETH/BTC'=>'BTC_ETH','STR/BTC'=>'BTC_STR','XRP/BTC'=>'BTC_XRP','LTC/BTC'=>'BTC_LTC','DASH/BTC'=>'BTC_DASH','XMR/BTC'=>'BTC_XMR','BCH/BTC'=>'BTC_BCH','VTC/BTC'=>'BTC_VTC','LSK/BTC'=>'BTC_LSK','ZEC/BTC'=>'BTC_ZEC','DGB/BTC'=>'BTC_DGB','STRAT/BTC'=>'BTC_STRAT','ETC/BTC'=>'BTC_ETC','OMG/BTC'=>'BTC_OMG','BTS/BTC'=>'BTC_BTS','XEM/BTC'=>'BTC_XEM','FCT/BTC'=>'BTC_FCT','DOGE/BTC'=>'BTC_DOGE','GAME/BTC'=>'BTC_GAME','SC/BTC'=>'BTC_SC','XVC/BTC'=>'BTC_XVC','CLAM/BTC'=>'BTC_CLAM','MAID/BTC'=>'BTC_MAID','SYS/BTC'=>'BTC_SYS','POT/BTC'=>'BTC_POT','BCN/BTC'=>'BTC_BCN','NXT/BTC'=>'BTC_NXT','NAV/BTC'=>'BTC_NAV','CVC/BTC'=>'BTC_CVC','GAS/BTC'=>'BTC_GAS','GNT/BTC'=>'BTC_GNT','VIA/BTC'=>'BTC_VIA','GNO/BTC'=>'BTC_GNO','ZRX/BTC'=>'BTC_ZRX','DCR/BTC'=>'BTC_DCR','STEEM/BTC'=>'BTC_STEEM','REP/BTC'=>'BTC_REP','ARDR/BTC'=>'BTC_ARDR','NEOS/BTC'=>'BTC_NEOS','BURST/BTC'=>'BTC_BURST','OMNI/BTC'=>'BTC_OMNI','LBC/BTC'=>'BTC_LBC','EXP/BTC'=>'BTC_EXP','FLO/BTC'=>'BTC_FLO','AMP/BTC'=>'BTC_AMP','PASC/BTC'=>'BTC_PASC','XCP/BTC'=>'BTC_XCP','NXC/BTC'=>'BTC_NXC','BELA/BTC'=>'BTC_BELA','FLDC/BTC'=>'BTC_FLDC','BLK/BTC'=>'BTC_BLK','PINK/BTC'=>'BTC_PINK','GRC/BTC'=>'BTC_GRC','RADS/BTC'=>'BTC_RADS','VRC/BTC'=>'BTC_VRC','SBD/BTC'=>'BTC_SBD','XBC/BTC'=>'BTC_XBC','NMC/BTC'=>'BTC_NMC','SJCX/BTC'=>'BTC_SJCX','NOTE/BTC'=>'BTC_NOTE','RIC/BTC'=>'BTC_RIC','PPC/BTC'=>'BTC_PPC','BTCD/BTC'=>'BTC_BTCD','BCY/BTC'=>'BTC_BCY','HUC/BTC'=>'BTC_HUC','XPM/BTC'=>'BTC_XPM','BTM/BTC'=>'BTC_BTM','NAUT/BTC'=>'BTC_NAUT'];
$yobitFinalArr = ['ETH/BTC'=>'ETH/BTC','LTC/BTC'=>'LTC/BTC','DASH/BTC'=>'DASH/BTC','VTC/BTC'=>'VTC/BTC','LSK/BTC'=>'LSK/BTC','ZEC/BTC'=>'ZEC/BTC','DGB/BTC'=>'DGB/BTC','ETC/BTC'=>'ETC/BTC','OMG/BTC'=>'OMG/BTC','BTS/BTC'=>'BTS/BTC','XEM/BTC'=>'XEM/BTC','DOGE/BTC'=>'DOGE/BTC','GAME/BTC'=>'GAME/BTC','CLAM/BTC'=>'CLAM/BTC','SYS/BTC'=>'SYS/BTC','NAV/BTC'=>'NAV/BTC','GNT/BTC'=>'GNT/BTC','VIA/BTC'=>'VIA/BTC','GNO/BTC'=>'GNO/BTC','DCR/BTC'=>'DCR/BTC','REP/BTC'=>'REP/BTC','EXP/BTC'=>'EXP/BTC','NMC/BTC'=>'NMC/BTC','NOTE/BTC'=>'NOTE/BTC','PPC/BTC'=>'PPC/BTC'];




$bittrexMarketBaseUrl = 'https://bittrex.com/Market/Index?MarketName=';//формат пары: "BTC-VTC"
$bitfinexMarketBaseUrl = 'https://www.bitfinex.com/trading/';//формат пары: "NEOBTC"
$liveCoinMarketBaseUrl = 'https://www.livecoin.net/ru/trade/index?currencyPair=';//формат пары: "CRBIT%2FBTC"
$yobitMarketBaseUrl = 'https://yobit.net/ru/trade/';//формат пары: "BTC/RUR"
$poloniexMarketBaseUrl = 'https://poloniex.com/exchange#';//формат пары: "btc_eth"
$exmoMarketBaseUrl = 'https://exmo.me/ru/trade#?pair=';//формат пары : "ETH_BTC"





$Btc_Pairs_arr_without_BTC = ['ETH','STR','XRP','LTC','DASH','XMR','BCH','VTC','LSK','ZEC','DGB','STRAT','ETC','OMG','BTS','EMC2','XEM','FCT','DOGE','GAME','SC','XVC','CLAM','MAID','SYS','POT','BCN','NXT','NAV','CVC','GAS','GNT','VIA','GNO','ZRX','DCR','STEEM','REP','ARDR','NEOS','BURST','OMNI','LBC','EXP','FLO','AMP','PASC','XCP','NXC','BELA','FLDC','BLK','PINK','GRC','RADS','VRC','SBD','XBC','NMC','SJCX','NOTE','RIC','PPC','BTCD','BCY','HUC','XPM','BTM','NAUT'];
$Btc_Pairs_arr = ['ETH/BTC','STR/BTC','XRP/BTC','LTC/BTC','DASH/BTC','XMR/BTC','BCH/BTC','VTC/BTC','LSK/BTC','ZEC/BTC','DGB/BTC','STRAT/BTC','ETC/BTC','OMG/BTC','BTS/BTC','EMC2/BTC','XEM/BTC','FCT/BTC','DOGE/BTC','GAME/BTC','SC/BTC','XVC/BTC','CLAM/BTC','MAID/BTC','SYS/BTC','POT/BTC','BCN/BTC','NXT/BTC','NAV/BTC','CVC/BTC','GAS/BTC','GNT/BTC','VIA/BTC','GNO/BTC','ZRX/BTC','DCR/BTC','STEEM/BTC','REP/BTC','ARDR/BTC','NEOS/BTC','BURST/BTC','OMNI/BTC','LBC/BTC','EXP/BTC','FLO/BTC','AMP/BTC','PASC/BTC','XCP/BTC','NXC/BTC','BELA/BTC','FLDC/BTC','BLK/BTC','PINK/BTC','GRC/BTC','RADS/BTC','VRC/BTC','SBD/BTC','XBC/BTC','NMC/BTC','SJCX/BTC','NOTE/BTC','RIC/BTC','PPC/BTC','BTCD/BTC','BCY/BTC','HUC/BTC','XPM/BTC','BTM/BTC','NAUT/BTC'];


class market {
	public $name=null;
	public $MarketBaseUrl=null;
	public $delimiter=null;
	public $haveAPI = null;
	public $htmlBasicRequest = null;
	public $allPairsArr = null;
	public $serverAns = null;
	public $bestprice = null;
}
class poloniex_com extends market{
	function __construct(){
		$this->name = 'poloniex.com';
		$this->MarketBaseUrl = 'https://poloniex.com/exchange#';
		$this->delimiter = '_';
		$this->haveAPI = true;
		$this->allPairsArr = ['BTC_BCN','BTC_BELA','BTC_BLK','BTC_BTCD','BTC_BTM','BTC_BTS','BTC_BURST','BTC_CLAM','BTC_DASH','BTC_DGB','BTC_DOGE','BTC_EMC2','BTC_FLDC','BTC_FLO','BTC_GAME','BTC_GRC','BTC_HUC','BTC_LTC','BTC_MAID','BTC_OMNI','BTC_NAUT','BTC_NAV','BTC_NEOS','BTC_NMC','BTC_NOTE','BTC_NXT','BTC_PINK','BTC_POT','BTC_PPC','BTC_RIC','BTC_SJCX','BTC_STR','BTC_SYS','BTC_VIA','BTC_XVC','BTC_VRC','BTC_VTC','BTC_XBC','BTC_XCP','BTC_XEM','BTC_XMR','BTC_XPM','BTC_XRP','USDT_BTC','USDT_DASH','USDT_LTC','USDT_NXT','USDT_STR','USDT_XMR','USDT_XRP','XMR_BCN','XMR_BLK','XMR_BTCD','XMR_DASH','XMR_LTC','XMR_MAID','XMR_NXT','BTC_ETH','USDT_ETH','BTC_SC','BTC_BCY','BTC_EXP','BTC_FCT','BTC_RADS','BTC_AMP','BTC_DCR','BTC_LSK','ETH_LSK','BTC_LBC','BTC_STEEM','ETH_STEEM','BTC_SBD','BTC_ETC','ETH_ETC','USDT_ETC','BTC_REP','USDT_REP','ETH_REP','BTC_ARDR','BTC_ZEC','ETH_ZEC','USDT_ZEC','XMR_ZEC','BTC_STRAT','BTC_NXC','BTC_PASC','BTC_GNT','ETH_GNT','BTC_GNO','ETH_GNO','BTC_BCH','ETH_BCH','USDT_BCH','BTC_ZRX','ETH_ZRX','BTC_CVC','ETH_CVC','BTC_OMG','ETH_OMG','BTC_GAS','ETH_GAS','BTC_STORJ'];
	}
	public $content;
	public $neededPair;
	public $pairFormat;
	public $poloniexFinalArr = ['ETH/BTC'=>'BTC_ETH','STR/BTC'=>'BTC_STR','XRP/BTC'=>'BTC_XRP','LTC/BTC'=>'BTC_LTC','DASH/BTC'=>'BTC_DASH','XMR/BTC'=>'BTC_XMR','BCH/BTC'=>'BTC_BCH','VTC/BTC'=>'BTC_VTC','LSK/BTC'=>'BTC_LSK','ZEC/BTC'=>'BTC_ZEC','DGB/BTC'=>'BTC_DGB','STRAT/BTC'=>'BTC_STRAT','ETC/BTC'=>'BTC_ETC','OMG/BTC'=>'BTC_OMG','BTS/BTC'=>'BTC_BTS','XEM/BTC'=>'BTC_XEM','FCT/BTC'=>'BTC_FCT','DOGE/BTC'=>'BTC_DOGE','GAME/BTC'=>'BTC_GAME','SC/BTC'=>'BTC_SC','XVC/BTC'=>'BTC_XVC','CLAM/BTC'=>'BTC_CLAM','MAID/BTC'=>'BTC_MAID','SYS/BTC'=>'BTC_SYS','POT/BTC'=>'BTC_POT','BCN/BTC'=>'BTC_BCN','NXT/BTC'=>'BTC_NXT','NAV/BTC'=>'BTC_NAV','CVC/BTC'=>'BTC_CVC','GAS/BTC'=>'BTC_GAS','GNT/BTC'=>'BTC_GNT','VIA/BTC'=>'BTC_VIA','GNO/BTC'=>'BTC_GNO','ZRX/BTC'=>'BTC_ZRX','DCR/BTC'=>'BTC_DCR','STEEM/BTC'=>'BTC_STEEM','REP/BTC'=>'BTC_REP','ARDR/BTC'=>'BTC_ARDR','NEOS/BTC'=>'BTC_NEOS','BURST/BTC'=>'BTC_BURST','OMNI/BTC'=>'BTC_OMNI','LBC/BTC'=>'BTC_LBC','EXP/BTC'=>'BTC_EXP','FLO/BTC'=>'BTC_FLO','AMP/BTC'=>'BTC_AMP','PASC/BTC'=>'BTC_PASC','XCP/BTC'=>'BTC_XCP','NXC/BTC'=>'BTC_NXC','BELA/BTC'=>'BTC_BELA','FLDC/BTC'=>'BTC_FLDC','BLK/BTC'=>'BTC_BLK','PINK/BTC'=>'BTC_PINK','GRC/BTC'=>'BTC_GRC','RADS/BTC'=>'BTC_RADS','VRC/BTC'=>'BTC_VRC','SBD/BTC'=>'BTC_SBD','XBC/BTC'=>'BTC_XBC','NMC/BTC'=>'BTC_NMC','SJCX/BTC'=>'BTC_SJCX','NOTE/BTC'=>'BTC_NOTE','RIC/BTC'=>'BTC_RIC','PPC/BTC'=>'BTC_PPC','BTCD/BTC'=>'BTC_BTCD','BCY/BTC'=>'BTC_BCY','HUC/BTC'=>'BTC_HUC','XPM/BTC'=>'BTC_XPM','BTM/BTC'=>'BTC_BTM','NAUT/BTC'=>'BTC_NAUT'];
	public $apiBasicRequest = 'https://poloniex.com/public?command=returnTicker';
	public $apiPairBaseRequest = 'https://bittrex.com/api/v1.1/public/getticker?market=';
	
	public function returnBestPricePair($currencyPair){
		
		$this->content = file_get_contents($this->apiBasicRequest);
		$array = json_decode($this->content,true);
		$this->bestprice = $array[$this->poloniexFinalArr[$currencyPair]]['highestBid'];
		
	}
}

class class1{
    public $name='string';
}
class class2 extends class1{
    function __construct(){
        $this->name = 'class2'; // Правильное обращение к свойству класса.
        echo $this->name;
    }
}

















function showStrForMakeArray ($arr, $nokeys=false){
	$rezStr = '[';
	if (!$nokeys){
		foreach ($arr as $key=> $val){
			if (is_array($val)){
				$rezStr .= '\''.$key.'\'' . '=>' . showStrForMakeingArray($val) . ',';
			} else {
				$rezStr .= '\''.$key.'\'=>\''.$val.'\',';
			}
		}
	} else {
		foreach ($arr as $key=> $val){
			if (is_array($val)){
				$rezStr .= showStrForMakeingArray($val) . ',';
			} else {
				$rezStr .= '\''.$val.'\',';
			}
		}
	}
	if ($rezStr[strlen($rezStr)-1] == ','){
		$rezStr = substr($rezStr,0,-1);
	}
	$rezStr .= ']';
	return $rezStr;
}
function onlyBTC($arr){
	$resArr = [];
	foreach ($arr as $key=>$val){
		if(preg_match('/^(.*[^a-z]+|\n?)btc($|[^a-z]+[a-z]*$)/mi', $val)!== 0){
			$resArr[] = $val;
		}
	}
	return $resArr;
}
function onlyNeeded($arr1, $arr2){
	foreach($arr1 as $val1){
		foreach($arr2 as $val2){
			if(preg_match('/^(.*[^a-z]+|\n?)'.$val1.'($|[^a-z]+[a-z]*$)/mi', $val2) !== 0){
				$resArr[$val1][] = $val2;
			}
		}
	}
	return $resArr;
}












/*------------------------------------------------------------------------------------------*/
//Нужно показать список пар или одну?
if (!empty($_GET['pair'])){
	$aas[] = $_GET['pair'];
	if (in_array($_GET['pair'], $Btc_Pairs_arr)){
		$showPair = $_GET['pair'];
		$showAllCurr = false;
		
		$sd = new poloniex_com;
		$sd -> returnBestPricePair($showPair);
		echo '<pre>';
		echo '_________________' . '<br>';
		echo $sd->bestprice . '<br>';
		echo '</pre>';
	} else {
		$showAllCurr = true;
	}
} else {
	$showAllCurr = true;
}



//Нужно ли показать примерную прибыль?
if(!empty($_GET['amount']) && isset($showPair)){
	
}


//Показываем список всех пар если нужно
if($showAllCurr){
	foreach($Btc_Pairs_arr as $key=>$val){
		echo "$key => ".'<a href="?pair='.$val.'">'. $val. '</a></br>';
	}
}










/*
//получить список всех рынков
echo  '<pre>';

$content = file_get_contents('https://api.bitfinex.com/v1/symbols');
$array = json_decode($content,true);
$po = [];
foreach($array as $key=>$val){
	$po[]=$val;
}
print_r($po);
echo showStrForMakeArray($po, 1) . '<br>';


echo  '</pre>';

*/









//Показываем котировки если нужно
if(!$showAllCurr){
	echo '<a href="?main=1">На главную</a><br>';
	//проверяем есть ли валюта на бирже bittrex и показываем если есть
	if(isset($bittrexFinalArr[$showPair])){
		$url = 'https://bittrex.com/api/v1.1/public/getticker?market='.$bittrexFinalArr[$showPair];
		if($content = @file_get_contents($url)){
			echo $url . '<br>';
			$array = json_decode($content,true);
			if ($array['success']){
				$buy = $array['result']['Bid'];
				$sell = $array['result']['Ask'];
			} else {
				$buy = $sell = 'Недоступно';
			}
		} else {
			$buy = $sell = 'Недоступно';
		}
		echo $showPair.', Bittrex.com' . '<br>';
		echo 'Покупают по: '. number_format($buy, 10, '.', '') . '<br>';
		echo 'Продают по: '. number_format($sell, 10, '.', '') . '<br>';
		echo '<br>';
	}

	//проверяем есть ли валюта на бирже yobit и показываем если есть
	if(isset($yobitFinalArr[$showPair])){
		$url = 'https://yobit.net/ru/trade/'.$yobitFinalArr[$showPair];
		$content = file_get_contents($url);
		echo $url . '<br>';
		$sellBegin = mb_strpos($content, '<div class="sm" id="label_bestbuy">')+35;
		$sellEnd = mb_strpos($content, '</div>', $sellBegin);
		$buyBegin = mb_strpos($content, '<div class="sm" id="label_bestsell">', $sellEnd)+36;
		$buyEnd = mb_strpos($content, '</div>', $buyBegin);
		$sell = mb_substr($content, $sellBegin, $sellEnd-$sellBegin);
		$buy =  mb_substr($content, $buyBegin, $buyEnd-$buyBegin);
		echo $showPair.', YoBit.Net' . '<br>';
		echo 'Покупают по: '. number_format($buy, 10, '.', '') . '<br>';
		echo 'Продают по: '. number_format($sell, 10, '.', '') . '<br>';
		echo '<br>';
	}

	//проверяем есть ли валюта на бирже exmo и показываем если есть
	if(isset($exmoFinalArr[$showPair])){
		$url = 'https://api.exmo.com/v1/ticker/';
		$content = file_get_contents($url);
		echo $url . '<br>';
		$array = json_decode($content,true);
		$buy = $array[$exmoFinalArr[$showPair]]['buy_price'];
		$sell = $array[$exmoFinalArr[$showPair]]['sell_price'];
		echo $showPair.', Exmo.com' . '<br>';
		echo 'Покупают по: '.number_format($buy, 10, '.', '') . '<br>';
		echo 'Продают по: '. number_format($sell, 10, '.', '') . '<br>';
		echo '<br>';
	}

	
	//проверяем есть ли валюта на бирже poloniex и показываем если есть
	if(isset($poloniexFinalArr[$showPair])){
		$url = 'https://poloniex.com/public?command=returnTicker';
		$content = file_get_contents($url);
		echo $url . '<br>';
		$array = json_decode($content,true);
		$buy = $array[$poloniexFinalArr[$showPair]]['highestBid'];
		$sell = $array[$poloniexFinalArr[$showPair]]['lowestAsk'];
		echo $showPair.', Poloniex.com' . '<br>';
		echo 'Покупают по: '.number_format($buy, 10, '.', '') . '<br>';
		echo 'Продают по: '. number_format($sell, 10, '.', '') . '<br>';
		echo '<br>';
	}

	//проверяем есть ли валюта на бирже bitfinex и показываем если есть
	if(isset($bitfinexFinalArr[$showPair])){
		$url = 'https://api.bitfinex.com/v1/pubticker/'.$bitfinexFinalArr[$showPair];
		$content = file_get_contents($url);
		echo $url . '<br>';
		$array = json_decode($content,true);
		$buy = $array['bid'];
		$sell = $array['ask'];
		echo $showPair.', Bitfinex.com' . '<br>';
		echo 'Покупают по: '.number_format($buy, 10, '.', '') . '<br>';
		echo 'Продают по: '. number_format($sell, 10, '.', '') . '<br>';
		echo '<br>';
	}

	//проверяем есть ли валюта на бирже livecoin и показываем если есть
	if(isset($liveCoinFinalArr[$showPair])){
		$url = 'https://api.livecoin.net/exchange/ticker?currencyPair='.$liveCoinFinalArr[$showPair];
		if($content = @file_get_contents($url)){
			echo $url . '<br>';
			$array = json_decode($content,true);
			$buy = $array['best_bid'];
			$sell = $array['best_ask'];
		} else {
			$buy = $sell = 'Недоступно';
		}
		echo $showPair.', Livecoin.net' . '<br>';
		echo 'Покупают по: '.number_format($buy, 10, '.', '') . '<br>';
		echo 'Продают по: '. number_format($sell, 10, '.', '') . '<br>';
		echo '<br>';
	}
}






?>