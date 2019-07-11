SQLMAP(1)                                                                                       User Commands                                                                                       SQLMAP(1)

NNAAMMEE
       sqlmap - automatic SQL injection tool

SSYYNNOOPPSSIISS
       ppyytthhoonn _s_q_l_m_a_p [_o_p_t_i_o_n_s]

OOPPTTIIOONNSS
       --hh, ----hheellpp
              Show basic help message and exit

       --hhhh    Show advanced help message and exit

       ----vveerrssiioonn
              Show program's version number and exit

       --vv VERBOSE
              Verbosity level: 0-6 (default 1)

              Target:

              At least one of these options has to be provided to define the target(s)

       --dd DIRECT
              Connection string for direct database connection

       --uu URL, ----uurrll=_U_R_L
              Target URL (e.g. "http://www.site.com/vuln.php?id=1")

       --ll LOGFILE
              Parse target(s) from Burp or WebScarab proxy log file

       --xx SITEMAPURL
              Parse target(s) from remote sitemap(.xml) file

       --mm BULKFILE
              Scan multiple targets given in a textual file

       --rr REQUESTFILE
              Load HTTP request from a file

       --gg GOOGLEDORK
              Process Google dork results as target URLs

       --cc CONFIGFILE
              Load options from a configuration INI file

              Request:

              These options can be used to specify how to connect to the target URL

       ----mmeetthhoodd=_M_E_T_H_O_D
              Force usage of given HTTP method (e.g. PUT)

       ----ddaattaa=_D_A_T_A
              Data string to be sent through POST

       ----ppaarraamm--ddeell=_P_A_R_A..
              Character used for splitting parameter values

       ----ccooookkiiee=_C_O_O_K_I_E
              HTTP Cookie header value

       ----ccooookkiiee--ddeell=_C_O_O..
              Character used for splitting cookie values

       ----llooaadd--ccooookkiieess=_L..
              File containing cookies in Netscape/wget format

       ----ddrroopp--sseett--ccooookkiiee
              Ignore Set-Cookie header from response

       ----uusseerr--aaggeenntt=_A_G_E_N_T
              HTTP User-Agent header value

       ----rraannddoomm--aaggeenntt
              Use randomly selected HTTP User-Agent header value

       ----hhoosstt=_H_O_S_T
              HTTP Host header value

       ----rreeffeerreerr=_R_E_F_E_R_E_R
              HTTP Referer header value

       --HH HEADER, ----hheeaa..
              Extra header (e.g. "X-Forwarded-For: 127.0.0.1")

       ----hheeaaddeerrss=_H_E_A_D_E_R_S
              Extra headers (e.g. "Accept-Language: fr\nETag: 123")

       ----aauutthh--ttyyppee=_A_U_T_H..
              HTTP authentication type (Basic, Digest, NTLM or PKI)

       ----aauutthh--ccrreedd=_A_U_T_H..
              HTTP authentication credentials (name:password)

       ----aauutthh--ffiillee=_A_U_T_H..
              HTTP authentication PEM cert/private key file

       ----iiggnnoorree--440011
              Ignore HTTP Error 401 (Unauthorized)

       ----pprrooxxyy=_P_R_O_X_Y
              Use a proxy to connect to the target URL

       ----pprrooxxyy--ccrreedd=_P_R_O..
              Proxy authentication credentials (name:password)

       ----pprrooxxyy--ffiillee=_P_R_O..
              Load proxy list from a file

       ----iiggnnoorree--pprrooxxyy
              Ignore system default proxy settings

       ----ttoorr  Use Tor anonymity network

       ----ttoorr--ppoorrtt=_T_O_R_P_O_R_T
              Set Tor proxy port other than default

       ----ttoorr--ttyyppee=_T_O_R_T_Y_P_E
              Set Tor proxy type (HTTP (default), SOCKS4 or SOCKS5)

       ----cchheecckk--ttoorr
              Check to see if Tor is used properly

       ----ddeellaayy=_D_E_L_A_Y
              Delay in seconds between each HTTP request

       ----ttiimmeeoouutt=_T_I_M_E_O_U_T
              Seconds to wait before timeout connection (default 30)

       ----rreettrriieess=_R_E_T_R_I_E_S
              Retries when the connection timeouts (default 3)

       ----rraannddoommiizzee=_R_P_A_R_A_M
              Randomly change value for given parameter(s)

       ----ssaaffee--uurrll=_S_A_F_E_U_R_L
              URL address to visit frequently during testing

       ----ssaaffee--ppoosstt=_S_A_F_E..
              POST data to send to a safe URL

       ----ssaaffee--rreeqq=_S_A_F_E_R..
              Load safe HTTP request from a file

       ----ssaaffee--ffrreeqq=_S_A_F_E..
              Test requests between two visits to a given safe URL

       ----sskkiipp--uurrlleennccooddee
              Skip URL encoding of payload data

       ----ccssrrff--ttookkeenn=_C_S_R..
              Parameter used to hold anti-CSRF token

       ----ccssrrff--uurrll=_C_S_R_F_U_R_L
              URL address to visit to extract anti-CSRF token

       ----ffoorrccee--ssssll
              Force usage of SSL/HTTPS

       ----hhpppp  Use HTTP parameter pollution method

       ----eevvaall=_E_V_A_L_C_O_D_E
              Evaluate provided Python code before the request (e.g.  "import hashlib;id2=hashlib.md5(id).hexdigest()")

              Optimization:

              These options can be used to optimize the performance of sqlmap

       --oo     Turn on all optimization switches

       ----pprreeddiicctt--oouuttppuutt
              Predict common queries output

       ----kkeeeepp--aalliivvee
              Use persistent HTTP(s) connections

       ----nnuullll--ccoonnnneeccttiioonn
              Retrieve page length without actual HTTP response body

       ----tthhrreeaaddss=_T_H_R_E_A_D_S
              Max number of concurrent HTTP(s) requests (default 1)

              Injection:

              These options can be used to specify which parameters to test for, provide custom injection payloads and optional tampering scripts

       --pp TESTPARAMETER
              Testable parameter(s)

       ----sskkiipp=_S_K_I_P
              Skip testing for given parameter(s)

       ----sskkiipp--ssttaattiicc
              Skip testing parameters that not appear dynamic

       ----ddbbmmss=_D_B_M_S
              Force back-end DBMS to this value

       ----ddbbmmss--ccrreedd=_D_B_M_S..
              DBMS authentication credentials (user:password)

       ----ooss=_O_S
              Force back-end DBMS operating system to this value

       ----iinnvvaalliidd--bbiiggnnuumm
              Use big numbers for invalidating values

       ----iinnvvaalliidd--llooggiiccaall
              Use logical operations for invalidating values

       ----iinnvvaalliidd--ssttrriinngg
              Use random strings for invalidating values

       ----nnoo--ccaasstt
              Turn off payload casting mechanism

       ----nnoo--eessccaappee
              Turn off string escaping mechanism

       ----pprreeffiixx=_P_R_E_F_I_X
              Injection payload prefix string

       ----ssuuffffiixx=_S_U_F_F_I_X
              Injection payload suffix string

       ----ttaammppeerr=_T_A_M_P_E_R
              Use given script(s) for tampering injection data

              Detection:

              These options can be used to customize the detection phase

       ----lleevveell=_L_E_V_E_L
              Level of tests to perform (1-5, default 1)

       ----rriisskk=_R_I_S_K
              Risk of tests to perform (1-3, default 1)

       ----ssttrriinngg=_S_T_R_I_N_G
              String to match when query is evaluated to True

       ----nnoott--ssttrriinngg=_N_O_T..
              String to match when query is evaluated to False

       ----rreeggeexxpp=_R_E_G_E_X_P
              Regexp to match when query is evaluated to True

       ----ccooddee=_C_O_D_E
              HTTP code to match when query is evaluated to True

       ----tteexxtt--oonnllyy
              Compare pages based only on the textual content

       ----ttiittlleess
              Compare pages based only on their titles

              Techniques:

              These options can be used to tweak testing of specific SQL injection techniques

       ----tteecchhnniiqquuee=_T_E_C_H
              SQL injection techniques to use (default "BEUSTQ")

       ----ttiimmee--sseecc=_T_I_M_E_S_E_C
              Seconds to delay the DBMS response (default 5)

       ----uunniioonn--ccoollss=_U_C_O_L_S
              Range of columns to test for UNION query SQL injection

       ----uunniioonn--cchhaarr=_U_C_H_A_R
              Character to use for bruteforcing number of columns

       ----uunniioonn--ffrroomm=_U_F_R_O_M
              Table to use in FROM part of UNION query SQL injection

       ----ddnnss--ddoommaaiinn=_D_N_S..
              Domain name used for DNS exfiltration attack

       ----sseeccoonndd--oorrddeerr=_S..
              Resulting page URL searched for second-order response

              Fingerprint:

       --ff, ----ffiinnggeerrpprriinntt
              Perform an extensive DBMS version fingerprint

              Enumeration:

              These options can be used to enumerate the back-end database management system information, structure and data contained in the tables. Moreover you can run your own SQL statements

       --aa, ----aallll
              Retrieve everything

       --bb, ----bbaannnneerr
              Retrieve DBMS banner

       ----ccuurrrreenntt--uusseerr
              Retrieve DBMS current user

       ----ccuurrrreenntt--ddbb
              Retrieve DBMS current database

       ----hhoossttnnaammee
              Retrieve DBMS server hostname

       ----iiss--ddbbaa
              Detect if the DBMS current user is DBA

       ----uusseerrss
              Enumerate DBMS users

       ----ppaasssswwoorrddss
              Enumerate DBMS users password hashes

       ----pprriivviilleeggeess
              Enumerate DBMS users privileges

       ----rroolleess
              Enumerate DBMS users roles

       ----ddbbss  Enumerate DBMS databases

       ----ttaabblleess
              Enumerate DBMS database tables

       ----ccoolluummnnss
              Enumerate DBMS database table columns

       ----sscchheemmaa
              Enumerate DBMS schema

       ----ccoouunntt
              Retrieve number of entries for table(s)

       ----dduummpp Dump DBMS database table entries

       ----dduummpp--aallll
              Dump all DBMS databases tables entries

       ----sseeaarrcchh
              Search column(s), table(s) and/or database name(s)

       ----ccoommmmeennttss
              Retrieve DBMS comments

       --DD DB  DBMS database to enumerate

       --TT TBL DBMS database table(s) to enumerate

       --CC COL DBMS database table column(s) to enumerate

       --XX EXCLUDECOL
              DBMS database table column(s) to not enumerate

       --UU USER
              DBMS user to enumerate

       ----eexxcclluuddee--ssyyssddbbss
              Exclude DBMS system databases when enumerating tables

       ----wwhheerree=_D_U_M_P_W_H_E_R_E
              Use WHERE condition while table dumping

       ----ssttaarrtt=_L_I_M_I_T_S_T_A_R_T
              First query output entry to retrieve

       ----ssttoopp=_L_I_M_I_T_S_T_O_P
              Last query output entry to retrieve

       ----ffiirrsstt=_F_I_R_S_T_C_H_A_R
              First query output word character to retrieve

       ----llaasstt=_L_A_S_T_C_H_A_R
              Last query output word character to retrieve

       ----ssqqll--qquueerryy=_Q_U_E_R_Y
              SQL statement to be executed

       ----ssqqll--sshheellll
              Prompt for an interactive SQL shell

       ----ssqqll--ffiillee=_S_Q_L_F_I_L_E
              Execute SQL statements from given file(s)

              Brute force:

              These options can be used to run brute force checks

       ----ccoommmmoonn--ttaabblleess
              Check existence of common tables

       ----ccoommmmoonn--ccoolluummnnss
              Check existence of common columns

              User-defined function injection:

              These options can be used to create custom user-defined functions

       ----uuddff--iinnjjeecctt
              Inject custom user-defined functions

       ----sshhaarreedd--lliibb=_S_H_L_I_B
              Local path of the shared library

              File system access:

              These options can be used to access the back-end database management system underlying file system

       ----ffiillee--rreeaadd=_R_F_I_L_E
              Read a file from the back-end DBMS file system

       ----ffiillee--wwrriittee=_W_F_I_L_E
              Write a local file on the back-end DBMS file system

       ----ffiillee--ddeesstt=_D_F_I_L_E
              Back-end DBMS absolute filepath to write to

              Operating system access:

              These options can be used to access the back-end database management system underlying operating system

       ----ooss--ccmmdd=_O_S_C_M_D
              Execute an operating system command

       ----ooss--sshheellll
              Prompt for an interactive operating system shell

       ----ooss--ppwwnn
              Prompt for an OOB shell, Meterpreter or VNC

       ----ooss--ssmmbbrreellaayy
              One click prompt for an OOB shell, Meterpreter or VNC

       ----ooss--bbooff
              Stored procedure buffer overflow exploitation

       ----pprriivv--eesscc
              Database process user privilege escalation

       ----mmssff--ppaatthh=_M_S_F_P_A_T_H
              Local path where Metasploit Framework is installed

       ----ttmmpp--ppaatthh=_T_M_P_P_A_T_H
              Remote absolute path of temporary files directory

              Windows registry access:

              These options can be used to access the back-end database management system Windows registry

       ----rreegg--rreeaadd
              Read a Windows registry key value

       ----rreegg--aadddd
              Write a Windows registry key value data

       ----rreegg--ddeell
              Delete a Windows registry key value

       ----rreegg--kkeeyy=_R_E_G_K_E_Y
              Windows registry key

       ----rreegg--vvaalluuee=_R_E_G_V_A_L
              Windows registry key value

       ----rreegg--ddaattaa=_R_E_G_D_A_T_A
              Windows registry key value data

       ----rreegg--ttyyppee=_R_E_G_T_Y_P_E
              Windows registry key value type

              General:

              These options can be used to set some general working parameters

       --ss SESSIONFILE
              Load session from a stored (.sqlite) file

       --tt TRAFFICFILE
              Log all HTTP traffic into a textual file

       ----bbaattcchh
              Never ask for user input, use the default behaviour

       ----cchhaarrsseett=_C_H_A_R_S_E_T
              Force character encoding used for data retrieval

       ----ccrraawwll=_C_R_A_W_L_D_E_P_T_H
              Crawl the website starting from the target URL

       ----ccrraawwll--eexxcclluuddee==..
              Regexp to exclude pages from crawling (e.g. "logout")

       ----ccssvv--ddeell=_C_S_V_D_E_L
              Delimiting character used in CSV output (default ",")

       ----dduummpp--ffoorrmmaatt=_D_U..
              Format of dumped data (CSV (default), HTML or SQLITE)

       ----eettaa  Display for each output the estimated time of arrival

       ----fflluusshh--sseessssiioonn
              Flush session files for current target

       ----ffoorrmmss
              Parse and test forms on target URL

       ----ffrreesshh--qquueerriieess
              Ignore query results stored in session file

       ----hheexx  Use DBMS hex function(s) for data retrieval

       ----oouuttppuutt--ddiirr=_O_U_T..
              Custom output directory path

       ----ppaarrssee--eerrrroorrss
              Parse and display DBMS error messages from responses

       ----ppiivvoott--ccoolluummnn=_P..
              Pivot column name

       ----ssaavvee=_S_A_V_E_C_O_N_F_I_G
              Save options to a configuration INI file

       ----ssccooppee=_S_C_O_P_E
              Regexp to filter targets from provided proxy log

       ----tteesstt--ffiilltteerr=_T_E..
              Select tests by payloads and/or titles (e.g. ROW)

       ----tteesstt--sskkiipp=_T_E_S_T..
              Skip tests by payloads and/or titles (e.g. BENCHMARK)

       ----uuppddaattee
              Update sqlmap

              Miscellaneous:

       --zz MNEMONICS
              Use short mnemonics (e.g. "flu,bat,ban,tec=EU")

       ----aalleerrtt=_A_L_E_R_T
              Run host OS command(s) when SQL injection is found

       ----aannsswweerrss=_A_N_S_W_E_R_S
              Set question answers (e.g. "quit=N,follow=N")

       ----bbeeeepp Beep on question and/or when SQL injection is found

       ----cclleeaannuupp
              Clean up the DBMS from sqlmap specific UDF and tables

       ----ddeeppeennddeenncciieess
              Check for missing (non-core) sqlmap dependencies

       ----ddiissaabbllee--ccoolloorriinngg
              Disable console output coloring

       ----ggppaaggee=_G_O_O_G_L_E_P_A_G_E
              Use Google dork results from specified page number

       ----iiddeennttiiffyy--wwaaff
              Make a thorough testing for a WAF/IPS/IDS protection

       ----sskkiipp--wwaaff
              Skip heuristic detection of WAF/IPS/IDS protection

       ----mmoobbiillee
              Imitate smartphone through HTTP User-Agent header

       ----oofffflliinnee
              Work in offline mode (only use session data)

       ----ppaaggee--rraannkk
              Display page rank (PR) for Google dork results

       ----ppuurrggee--oouuttppuutt
              Safely remove all content from output directory

       ----ssmmaarrtt
              Conduct thorough tests only if positive heuristic(s)

       ----ssqqllmmaapp--sshheellll
              Prompt for an interactive sqlmap shell

       ----wwiizzaarrdd
              Simple wizard interface for beginner users

sqlmap.py v0.9                                                                                  December 2015                                                                                       SQLMAP(1)
