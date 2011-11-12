Installation:

  See INSTALL.TXT

Troubleshooting: (text taken from XOOPS post by intel352 - Jul 9 2005)

These are the most common problems affecting developers when
working with IPN. The most common solutions are noted as well. Hope
this information helps someone out there!

REASONS FOR INVALID
- Make sure you are posting back ALL variables/values.

For PayPal to return VERIFIED, your IPN script needs to post back ALL the
variables that were posted to it in the first place. In other words, if
your script only needs to manipulate 1 or 2 variables, it is not enough
to post back to PayPal only the variables/values your script is
concerned with. Your script should post back EVERYTHING that was
initially posted to it from PayPal. This is the only way PayPal will
return VERIFIED.

- Make sure you are not posting back to the wrong URL.

If you are testing in the Sandbox, you need to ensure your script posts
back to www.sandbox.paypal.com. If you are on the live site, the script
should post back to www.paypal.com. You will receive INVALID if you are
testing in the Sandbox and your script posts back to the live site (or
vice versa)

TROUBLESHOOTING TIPS
- IPN is not POSTing!
  - Email address on receiving account.
  Make sure you've confirmed the email address on the account the payment is
  being sent to.

  - Access Logs
  If you feel IPN is not posting to your script, you can verify this by
  checking your server's access logs. The server access logs will tell
  you if PayPal is "hitting your script" at all. An access log tracks the
  IP addresses and/or hostnames of computers that access the server.

  That you can access your server's access logs is up to the server admin. Check
  with them if you do not know where the logs are.

  - Error logs
  Most scripting languages output to error logs if an error occurs when
  running the script. If you see in your access logs that PayPal is
  sending the IPN but you are not seeing the intended end result from
  your script, odds are you have a logic or syntax error in the script.
  Check your error logs to verify.

  Again, if you don't know how or where to check these logs, you would need to
  consult your server's administrator.

  - Check Paths
  An easy mistake to make. Always ensure the path to your script is correct
  when testing/using IPN and you feel that you are not getting an IPN
  post.

  - Firewalls
  IPN is an HTTP POST initiated from PayPal. If you have a firewall on your
  server, make sure your firewall is not blocking the post from PayPal.

  - IPN posts to your return URL (added 8/22/05)
  Some merchants are setup such that they would like to get IPN data posted to
  the value of their return variable in their button code (return URL). This
  is the URL the buyer is directed to after a PayPal payment has been made. As
  of the last PayPal site update which occurred on 8/19/05, it is no longer
  enough to have IPN enabled in your PayPal account profile to have IPN data
  POSTed to your return URL. As of now, you MUST set the rm variable equal to "2"
  in your button code or you will not see any IPN data POSTed to your return URL.
  For more information see:
  http://paypal.forums.liveworld.com/thread.jspa?threadID=400000598&tstart=0&start=-1"

  Note that this information is about IPN and how it works with your return URL
  (button code variable 'return'). If you have Auto Return with PDT enabled (or
  Auto Return by itself) this information does not apply to you. See:
  http://paypal.forums.liveworld.com/thread.jspa?threadID=400000162</a>
