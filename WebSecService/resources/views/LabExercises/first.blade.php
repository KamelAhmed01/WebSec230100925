<x-layout>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">Interactive Demo</h1>
    </div>

    <script>
        function sayHello() {
            const name = document.getElementById('nameInput').value;
            if (name) {
                alert("Hello, " + name + "!");
            } else {
                alert("Please enter your name!");
            }
        }
    </script>

    <!-- First card with name input -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="bg-blue-600 text-white px-6 py-4">
            <h4 class="text-xl font-semibold">Greeting Card</h4>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <label for="nameInput" class="block text-gray-700 text-sm font-bold mb-2">Enter your name:</label>
                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500" id="nameInput" placeholder="Your name">
            </div>
            <button type="button" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" onclick="sayHello()">Greet Me!</button>
        </div>
    </div>

    <!-- New interactive buttons functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            let clickCount = 0;
            const gifUrl = 'https://media0.giphy.com/media/v1.Y2lkPTc5MGI3NjExcDIxNHZibzlzd25menJpMThvanB1ZXpucDV4OHQ1dnliajNwY2RsNSZlcD12MV9pbnRlcm5naWZfYnlfaWQmY3Q9Zw/26uf1EUQzKKGcIhJS/giphy.gif';

            document.getElementById("btn1").addEventListener('click', function(){
                document.getElementById("btn2").classList.remove('hidden');
            });

            document.getElementById("btn2").addEventListener('click', function(){
                clickCount++;

                if (clickCount < 6) {
                    const listItem = document.createElement('li');
                    listItem.className = "py-1";
                    listItem.textContent = "Hello";
                    document.getElementById("ul1").appendChild(listItem);
                }
                else if (clickCount >= 6 && clickCount <= 10) {
                    // Clear previous content
                    document.getElementById("ul1").innerHTML = '';

                    // Calculate size based on click count
                    const size = 100 + (clickCount - 6) * 50; // Increases by 50px each click

                    // Add gif with dynamic size
                    const img = document.createElement('img');
                    img.src = gifUrl;
                    img.width = size;
                    img.height = size;
                    document.getElementById("ul1").appendChild(img);
                }
                else {
                    // Reset everything after 10th click
                    clickCount = 0;
                    document.getElementById("ul1").innerHTML = '';
                }
            });
        });
    </script>

    <!-- Second card with interactive buttons -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-blue-600 text-white px-6 py-4">
            <h4 class="text-xl font-semibold">Interactive Buttons</h4>
        </div>
        <div class="p-6">
            <button type="button" id="btn1" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 mr-2">Press Me</button>
            <button type="button" id="btn2" class="hidden px-4 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Press Me Again</button>
            <ul id="ul1" class="mt-4 pl-5 list-disc">
            </ul>
        </div>
    </div>
</x-layout>

