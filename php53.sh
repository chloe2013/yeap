#!/bin/sh

OPTS="-rHw"; verbose=0
while [ $# -gt 0 ]; do
  case $1 in
    -v)
      verbose=1; shift ;;
    -q)
      verbose=0; shift ;;
    -*)
      OPTS="$OPTS $1"; shift ;;
    *)
      break; ;;
  esac
done

if [ $# -eq 0 ]; then
  echo "Usage $0 [-v] "
  exit 1
fi

[ $verbose -eq 0 ] && OPTS="$OPTS -l"

DEPRECATED="call_user_method call_user_method_array define_syslog_variables
            dl set_magic_quotes_runtime magic_quotes_runtime
            set_socket_blocking sql_regcase
            mysql_db_query mysql_escape_string
            session_register session_unregister session_is_registered
            eregi? eregi?_replace spliti?"

OPTS="$OPTS --include=*.inc --include=*.php --include=*.php5"

for item in $DEPRECATED; do
  echo "##### find deprecated item: $item in $1: #####"
  grep $OPTS -E "$item/s*$" $*
  grep $OPTS -E "$item/s*/(" $*
  echo ""
done
