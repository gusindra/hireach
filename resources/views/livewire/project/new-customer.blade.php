<div>
    <div class="border-b border-solid rounded-t-2xl border-b-slate-100">
        <div multisteps-form="" class="mb-12">
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 mx-auto my-12 flex-0 lg:w-8/12">
                    <div class="grid grid-cols-2">
                        <button aria-controls="user" type="button"
                            class="before:w-3.4 before:h-3.4 before:rounded-circle before:scale-120 rounded-0 -indent-330 relative m-0 cursor-pointer border-none bg-transparent px-1.5 pb-0.5 pt-5 text-slate-700 outline-none transition-all ease-linear before:absolute before:top-0 before:left-1/2 before:z-30 before:box-border before:block before:-translate-x-1/2 before:border-2 before:border-solid before:border-current before:bg-current before:transition-all before:ease-linear before:content-[''] sm:indent-0"
                            title="User Info"><span class="text-slate-400">Customer Info</span></button>
                        <button aria-controls="project" type="button"
                            class="before:w-3.4 before:h-3.4 before:rounded-circle after:top-1.25 rounded-0 -indent-330 relative m-0 cursor-pointer border-none bg-transparent px-1.5 pb-0.5 pt-5 text-slate-100 outline-none transition-all ease-linear before:absolute before:top-0 before:left-1/2 before:z-30 before:box-border before:block before:-translate-x-1/2 before:border-2 before:border-solid before:border-current before:bg-white before:transition-all before:ease-linear before:content-[''] after:absolute after:left-[calc(-50%-13px/2)] after:z-10 after:block after:h-0.5 after:w-full after:bg-current after:transition-all after:ease-linear after:content-[''] sm:indent-0"
                            title="Profile">Project Data</button>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 m-auto flex-0 lg:w-8/12">
                    <form class="relative mb-32" style="height: 403px;">
                        <div form="user"
                            class="absolute top-0 left-0 flex flex-col w-full min-w-0 p-4 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border h-auto opacity-100 visible"
                            active="">
                            <div>
                                <div class="col-span-6 sm:col-span-4 p-3">
                                    <x-jet-label for="input.name" value="{{ __('Name') }}" />
                                    <x-jet-input id="input.name" type="text" class="mt-1 block w-full"
                                        wire:model.debunce.800ms="input.name" autofocus />
                                    <x-jet-input-error for="input.name" class="mt-2" />
                                </div>
                                <div class="col-span-6 sm:col-span-4 p-3">
                                    <x-jet-label for="input.email" value="{{ __('Email') }}" />
                                    <x-jet-input autocomplete="off" id="input.email" type="text"
                                        class="mt-1 block w-full" wire:model.debunce.800ms="input.email" autofocus />
                                    <x-jet-input-error for="input.email" class="mt-2" />
                                </div>
                                <div class="col-span-6 sm:col-span-4 p-3 grid grid-cols-3 gap-3">
                                    <div class="col-span-2">
                                        <x-jet-label for="input.password" value="{{ __('Password') }}" />
                                        <!-- <x-jet-input id="input.password" type="password" class="mt-1 block w-full" wire:model.debunce.800ms="input.password" autofocus /> -->
                                        <div class="relative" x-data="{ input: 'password' }">
                                            <input autocomplete="off" id="input.password"
                                                class="p-2 border dark:bg-slate-800 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                                                wire:model.debunce.800ms="input.password" autofocus
                                                name="input.password" type="password" x-bind:type="input">
                                            <div class="absolute right-0 top-0 mr-2 mt-2"
                                                x-on:click="input = (input === 'password') ? 'text' : 'password'">
                                                <span
                                                    class="body text-xs text-show-hide text-gray-600 uppercase cursor-pointer"
                                                    x-text="input == 'password' ? 'show' : 'hide'">show</span>
                                            </div>
                                        </div>
                                        <x-jet-input-error for="input.password" class="mt-2" />
                                    </div>
                                    <div class="col-span-1">
                                        <x-jet-secondary-button class="mt-6 py-3" wire:click="generatePassword"
                                            wire:loading.attr="disabled">
                                            {{ __('Auto Password') }}
                                        </x-jet-secondary-button>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <!-- Name -->
                                <div class="col-span-6 sm:col-span-3 grid grid-cols-2 gap-2">
                                    <div class="col-span-12 sm:col-span-1">
                                        <x-jet-label for="title" value="{{ __('Title') }}" />
                                        <select name="title" id="title"
                                            class="border-gray-300 dark:bg-slate-800 h-10 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                                            wire:model.debunce.800ms="inputclient.title">
                                            <option selected>-- Select --</option>
                                            <option value="Mr.">Mr.</option>
                                            <option value="Mrs.">Mrs.</option>
                                            <option value="Miss">Miss</option>
                                            <option value="Ms.">Ms.</option>
                                            <option value="PT.">PT.</option>
                                            <option value="CV.">CV.</option>
                                            <option value="none">None</option>
                                        </select>
                                        <x-jet-input-error for="title" class="mt-2" />
                                    </div>
                                    <div class="col-span-12 sm:col-span-1">
                                        <x-jet-label for="inputclient.name" value="{{ __('Name') }}" />
                                        <x-jet-input id="client_name" type="text" class="mt-1 block w-full"
                                            wire:model="inputclient.name" wire:model.defer="inputclient.name"
                                            wire:model.debunce.800ms="inputclient.name" />
                                        <x-jet-input-error for="inputclient.name" class="mt-2" />
                                    </div>
                                </div>
                                <!-- Nick -->
                                <div class="col-span-6 sm:col-span-3 grid grid-cols-2 gap-2">
                                    <div class="col-span-12 sm:col-span-1">
                                        <x-jet-label for="inputclient.phone" value="{{ __('Phone') }}" />
                                        <x-jet-input id="client_phone" type="text" class="mt-1 block w-full"
                                            wire:model="inputclient.phone" wire:model.defer="inputclient.phone"
                                            wire:model.debunce.800ms="inputclient.phone" />
                                        <x-jet-input-error for="inputclient.phone" class="mt-2" />
                                    </div>
                                    <div class="col-span-12 sm:col-span-1">
                                        <x-jet-label for="inputclient.tax_id" value="{{ __('Tax ID / NPWP') }}" />
                                        <x-jet-input id="inputclient.tax_id" type="text" class="mt-1 block w-full"
                                            wire:model="inputclient.tax_id" wire:model.defer="inputclient.tax_id"
                                            wire:model.debunce.800ms="inputclient.tax_id" />
                                        <x-jet-input-error for="inputclient.tax_id" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-3 grid grid-cols-2 gap-2">
                                    <div class="col-span-12 sm:col-span-1">
                                        <x-jet-label for="inputclient.postcode" value="{{ __('Post Code') }}" />
                                        <x-jet-input id="postcode" type="text" class="mt-1 block w-full"
                                            wire:model="inputclient.postcode"
                                            wire:model.defer="inputclient.postcode"
                                            wire:model.debunce.800ms="inputclient.postcode" />
                                        <x-jet-input-error for="inputclient.postcode" class="mt-2" />
                                    </div>
                                    <div class="col-span-12 sm:col-span-1">
                                        <x-jet-label for="inputclient.address" value="{{ __('Address') }}" />
                                        <x-jet-input id="address" type="text" class="mt-1 block w-full"
                                            wire:model="inputclient.address" wire:model.defer="inputclient.address"
                                            wire:model.debunce.800ms="inputclient.address" />
                                        <x-jet-input-error for="inputclient.address" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-3 grid grid-cols-2 gap-2">
                                    <div class="col-span-12 sm:col-span-1">
                                        <x-jet-label for="inputclient.province" value="{{ __('Province') }}" />
                                        <x-jet-input id="province" type="text" class="mt-1 block w-full"
                                            wire:model="inputclient.province"
                                            wire:model.defer="inputclient.province"
                                            wire:model.debunce.800ms="inputclient.province" />
                                        <x-jet-input-error for="inputclient.province" class="mt-2" />
                                    </div>
                                    <div class="col-span-12 sm:col-span-1">
                                        <x-jet-label for="inputclient.city" value="{{ __('City') }}" />
                                        <x-jet-input id="city" type="text" class="mt-1 block w-full"
                                            wire:model="inputclient.city" wire:model.defer="inputclient.city"
                                            wire:model.debunce.800ms="inputclient.city" />
                                        <x-jet-input-error for="inputclient.city" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-3">
                                    <x-jet-label for="inputclient.notes" value="{{ __('Notes') }}" />
                                    <x-jet-input id="notes" type="text" class="mt-1 block w-full"
                                        wire:model="inputclient.notes" wire:model.defer="inputclient.notes"
                                        wire:model.debunce.800ms="inputclient.notes" />
                                    <x-jet-input-error for="inputclient.notes" class="mt-2" />
                                </div>
                                <!-- <div class="flex flex-wrap mt-4 -mx-3">
                                                <div class="w-full max-w-full px-3 flex-0 sm:w-6/12">
                                                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" for="First Name">First Name</label>
                                                    <input type="text" name="First Name" placeholder="eg. Michael" class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                                                </div>
                                                <div class="w-full max-w-full px-3 mt-4 flex-0 sm:mt-0 sm:w-6/12">
                                                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" for="Last Name">Last Name</label>
                                                    <input type="text" name="Last Name" placeholder="eg. Prior" class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                                                </div>
                                            </div>
                                            <div class="flex flex-wrap mt-4 -mx-3">
                                                <div class="w-full max-w-full px-3 mt-4 flex-0 sm:mt-0 sm:w-12">
                                                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" for="Email Address">Email Address</label>
                                                    <input type="email" name="Email Address" placeholder="eg. soft@company.com" class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                                                </div>
                                            </div>
                                            <div class="flex flex-wrap mt-4 -mx-3">
                                                <div class="w-full max-w-full px-3 flex-0 sm:w-6/12">
                                                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" for="Password">Password</label>
                                                    <input type="password" name="Password" placeholder="******" class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                                                </div>
                                                <div class="w-full max-w-full px-3 mt-4 flex-0 sm:mt-0 sm:w-6/12">
                                                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" for="Repeat Password">Repeat Password</label>
                                                    <input type="password" name="Repeat Password" placeholder="******" class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                                                </div>
                                            </div> -->
                                <div class="flex mt-6">
                                    <button type="button" aria-controls="project" next-form-btn="" href="javascript:;"
                                        class="inline-block px-6 py-3 mb-0 ml-auto font-bold text-right text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 hover:shadow-soft-xs dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 bg-gradient-to-tl from-gray-900 to-slate-800 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25">Next</button>
                                </div>
                            </div>
                        </div>
                        <div form="project"
                            class="absolute top-0 left-0 flex flex-col invisible w-full h-0 min-w-0 p-4 break-words bg-white border-0 opacity-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                            <h5 class="font-bold dark:text-white">Project</h5>
                            <div>
                                <div class="flex flex-wrap mt-4 -mx-3">
                                    <div class="w-full max-w-full px-3 flex-0">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80"
                                            for="Public Email">Project Title</label>
                                        <x-jet-input id="name" type="text" class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                                            wire:model="name" wire:model.defer="name"
                                            wire:model.debunce.800ms="name" />
                                    </div>
                                </div>
                                <div class="flex flex-wrap mt-4 -mx-3">
                                    <div class="w-full max-w-full px-3 flex-0">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80"
                                            for="Public Email">Project Title</label>
                                        <select name="type" id="type"
                                            class="px-3 py-2 border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                                            wire:model.debunce.800ms="type">
                                            <option selected>-- Select Type --</option>
                                            <option value="selling">Selling Product / Annexed Service</option>
                                            <option value="saas">SAAS Service</option>
                                            <option value="referral">Referral</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex mt-6">
                                    <button type="button" aria-controls="user" prev-form-btn="" href="javascript:;"
                                        class="inline-block px-6 py-3 mb-0 font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 hover:shadow-soft-xs bg-gradient-to-tl from-gray-400 to-gray-100 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 text-slate-800">Prev</button>
                                    <button type="button" wire:click="update({{$project->id}})"
                                        class="inline-block px-6 py-3 mb-0 ml-auto font-bold text-right text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 hover:shadow-soft-xs dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 bg-gradient-to-tl from-gray-900 to-slate-800 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
