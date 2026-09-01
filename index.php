<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ToDo List</title>
    <link rel="stylesheet" href="output.css" />
    <script src="script.js" defer></script>
    <style>
      .onwen {
        text-align: center;
        font-size: 2rem;
        font-weight: bold;
        background: linear-gradient(
          to right,
          #ff6b6b,
          #feca57,
          #48dbfb,
          #ff9ff3
        );
        background-size: 300% 100%;
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        animation: colorShift 4s ease-in-out infinite;
      }

      @keyframes colorShift {
        0% {
          background-position: 0% 50%;
        }
        50% {
          background-position: 100% 50%;
        }
        100% {
          background-position: 0% 50%;
        }
      }
      #add::backdrop,#modi::backdrop
      {
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px); /*safari*/
      }
    </style>
  </head>
  <body class="mt-2 ml-1 bg-black">
    <div class="flex flex-row w-full">
      <button
        class="text-white font-extrabold text-[20px] bg-red-500 px-6 py-3 rounded-2xl transition duration-300 hover:bg-red-600 hover:shadow-[0_0_30px_rgba(239,68,68,0.7)]"
        onclick="opentask()"
      >
        +
      </button>
      <header class="onwen ml-[43%] items-center justify-center">
        ToDo List
      </header>
    </div><br><br>
    <?php
              require 'config.php';
              $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
              if (!$con) { die("Connection failed: " . mysqli_connect_error()); }
              $res=mysqli_query($con,"SELECT * FROM tasks");
              while ($row = mysqli_fetch_row($res)) {
                  $t=["bg-amber-500","bg-fuchsia-900","bg-gray-600","bg-teal-600","bg-yellow-900"];
                  $id=($row[0]-1+5)%5 ;
                  echo "
                  <div class='flex flex-row'>
                    <div class='flex flex-col ".$t[$id]."  rounded-2xl w-[40%] pl-2 py-4'>
                          <p class='text-white text-3xl ' style='font-family:algerian'>" . htmlspecialchars($row[1]) . "</p><br>
                          <article class='text-white text-[26px]'>" . htmlspecialchars($row[2]) . "</article>
                    </div>
                    <div class='flex flex-col px-4 py-2 space-y-3'>            
                          <button
                          onclick='openmodi(". json_encode($row) .")'
                          class='text-white bg-blue-500 px-6 py-3 rounded-lg transition duration-300 hover:bg-blue-600 hover:shadow-[0_0_30px_rgba(59,130,246,0.7)]'
                        >
                          Modify
                        </button>
                        <form method='POST' action='action.php' class='inline'>
                        <input type='hidden' name='action' value='" . htmlspecialchars($row[0]) . "'>
                        <button type='submit'
                          class='text-white bg-green-500 px-6 py-3 rounded-lg transition duration-300 hover:bg-green-600 hover:shadow-[0_0_30px_rgba(34,197,94,0.7)]'>
                          Done
                        </button>
                      </form>
                    </div>
                  </div><br><br>";
                      }
    ?>
    <dialog id="add" class="m-auto bg-transparent w-150">
      <form action="action.php" method="POST" onsubmit="return verif()">
        <input type="hidden" name="action" value="add" />
        <h2 class="onwen">ADD</h2>
        <div class="flex flex-col w-[90%] ml-5 space-y-2">
          <label class="font-bold text-pink-900"> Title:</label>
          <input
            class="border-4 border-pink-700 text-white"
            type="text"
            name="title"
            id="title"
            required
          />
        </div>
        <br />

        <br />

        <div class="flex flex-col w-[90%] ml-5 space-y-2">
          <label class="mb-10 font-bold text-pink-900"> Description:</label>
          <textarea
            class="border-4 border-pink-700 text-white"
            name="desc"
            id="desc"
            cols="30"
            rows="10"
            required
          ></textarea>
        </div>
        <br />
        <div class="space-x-2">
          <button
            class="font-bold bg-pink-900 text-white rounded-md w-[30%] mb-1 pb-1 ml-17 hover:text-green-500 hover:bg-purple-950"
            type="submit"
          >
            Add Task
          </button>
          <button
            class="font-bold bg-pink-900 text-white rounded-md w-[30%] mb-1 pb-1 ml-17 hover:text-green-500 hover:bg-purple-950"
            type="reset"
          >
            Reset
          </button>
        </div>
      </form>
    </dialog>
    <dialog id="modi" class="m-auto bg-transparent w-150">
      <form action="action.php" method="POST" onsubmit="return verif()">
        <input type="hidden" name="action" value="modi" />
        <h2 class="onwen">Modify</h2>
        <div class="flex flex-col w-[90%] ml-5 space-y-2">
          <input type="number" name="id" id="idm" hidden>
          <label class="font-bold text-pink-900"> Title:</label>
          <input
            class="border-4 border-pink-700 text-white"
            type="text"
            name="title"
            id="titlem"
            required
          />
        </div>
        <br />

        <br />

        <div class="flex flex-col w-[90%] ml-5 space-y-2">
          <label class="mb-10 font-bold text-pink-900"> Description:</label>
          <textarea
            class="border-4 border-pink-700 text-white"
            name="desc"
            id="descm"
            cols="30"
            rows="10"
            required
          ></textarea>
        </div>
        <br />
        <div class="space-x-2">
          <button
            class="font-bold bg-pink-900 text-white rounded-md w-[30%] mb-1 pb-1 ml-17 hover:text-green-500 hover:bg-purple-950"
            type="submit"
          >
            Modify Task
          </button>
          <button
            class="font-bold bg-pink-900 text-white rounded-md w-[30%] mb-1 pb-1 ml-17 hover:text-green-500 hover:bg-purple-950"
            type="reset"
          >
            Reset
          </button>
        </div>
      </form>
    </dialog>
  </body>
</html>
