<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

echo <<<EOF
## What is the difference between a queue and a stack?

A stack is first in last out, where a queue is first in first out.  You'd build a queue if you wanted tasks to be 
completed in the order that they were inserted.  You'd build a stack if you wanted tasks to be completed starting with
the most recently added task.

Queues are quite frequently found, especially when building applications that require a back-end worker to perform tasks
for which a response is not immediately expected by a user, or tasks that run periodically.
    Example: Swiftmail's spool queue

Stack's are found less frequently in my experience, the most obvious example I can think of is Javascript's event stack. 

EOF;
