# nodegrid
PHP package i made for fun to send soap requests to RCCService/RBXGS
# classes

NodeGrid::OpenJob(string $script, string $jobid, int $jobExpiration): Used for sending a SoapAction with type OpenJob.
NodeGrid::execute(string $jobid, string $script): Used for sending execute requests to RCCService. this requires an open Job in your RCCService console.


We are working for other functions like closing all jobs... etc. Stay tuned...

#how to set up
if you set up a composer project already. use this bash:
```
composer require node/nodegrid
```
Or if you not:
```
composer init
composer require node/nodegrid
```

# examples
Example for making a render for a Player:
```
<?php
require __DIR__ . "/vendor/autoload.php"
use Node/NodeGrid;
echo base64_decode(NodeGrid::OpenJob("
local Thumbmaker = game:GetService(\"ThumbnailGenerator\")
local plr = game:GetService(\"Players\"):CreateLocalPlayer(0)
plr:LoadCharacter()
return Thumbmaker:Click('PNG', 1200, 1200, true)
", rand()));
```
