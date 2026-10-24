@php($tabs = [['id' => 1, 'name' => 'Squirrels'], ['id' => 2, 'name' => 'Little Lambs'], ['id' => 3, 'name' => 'Beavers']])
<div class="section-curriculum bg-secondary pb-30 mobile:pb-20">
  <div class="container-xl desktop_extralarge:pl-[50px] desktop_extralarge:pr-[50px] desktop:px-10 tablet:px-6">
    <div class="rounded-xl bg-white px-24 pb-8 pt-16 desktop_large:px-16 mobile:px-9 mobile:py-9">
      <div class="achievement-tabs-nav">
        <ul class="mobile:-mx-4">
          @foreach ($tabs as $item)
            <li @class(['active' => $item['id'] === 1])>
            <a href="#curriculum-tab-{{ $item['id'] }}">
              {{ $item['name'] }}
            </a>
            </li>
          @endforeach
        </ul>
      </div>
      <div class="achievement-tabs-content text-primary">
        
          <div id="curriculum-tab-1">
            <div class="pt-22 mobile:pt-12">
              <h3 class="mb-6 mobile:text-center">
                <strong>
                  Requirements
                </strong>
              </h3>
              <div class="-mx-9 mb-13 flex flex-wrap desktop_medium:-mx-4 tablet:mb-6">
                <div class="mb-12 w-1/4 px-9 text-center desktop_medium:px-4 tablet:w-1/2 mobile-small:w-full">
                  <img class="mb-3 inline-block" src="{{ asset('images/ministries/insignias/squirrels/squirrels.png') }}"
                    alt="squirrels">
                </div>
              </div>
              <div class="-mx-12 mb-24 flex flex-wrap desktop_medium:-mx-6 tablet:mb-11 mobile:mb-0">
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  
                  <div>
                    <h3 class="mobile:text-center mobile:text-xl">
                      <strong>
                        MY CLUB
                      </strong>
                    </h3>
                    <ol class="mb-9 pl-5">
                      <li>
                        Be 3 years old.
                      </li>
                      <li>
                        Learn the Pledge.
                      </li>
                      <li>
                        Recognize the Law.
                      </li>
                      <li>
                        Recognize the song of the “Cachorros.”
                      </li>
                      <li>
                        Have a basic knowledge of squirrels
                      </li>
                      <li>
                        And do an activity to demonstrate what you have learned.
                      </li>
                    </ol>
                  </div>
                  
                  <div>
                    <h3 class="mobile:text-center mobile:text-xl">
                      <strong>
                        MY GOD
                      </strong>
                    </h3>
                    <ol class="mb-9 pl-5" start="7">
                      <li>
                        Understand Jesus’ love and care has for children by learning Matthew 19:14.
                      </li>
                      <li>
                        Study the story of Joseph and do a drawing of what you have learned.
                      </li>
                      <li>
                        Learn the first part of the fourth commandment by heart.
                      </li>
                      <li>
                        Welcome the Sabbath with your family during 1 month.
                      </li>
                      <li>
                        Help the deacon collect the offering during 1 Sabbath.
                      </li>
                      <li>
                        Complete the honor: “My First Bible.”
                      </li>
                    </ol>
                  </div>
                  
                  <div>
                    <h3 class="mobile:text-center mobile:text-xl">
                      <strong>
                        MY LIFE
                      </strong>
                    </h3>
                    <ol class="pl-5" start="13">
                      <li>
                        Learn your full name.
                      </li>
                      <li>
                        Learn to get dressed on your own.
                      </li>
                      <li>
                        Learn to brush your teeth by yourself
                      </li>
                    </ol>
                  </div>
                </div>

                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  
                  <div>
                    <h3 class="mobile:text-center mobile:text-xl">
                      <strong>
                        MY FAMILY
                      </strong>
                    </h3>
                    <ol class="mb-9 pl-5" start="16">
                      <li>
                        Learn about the family.
                      </li>
                      <li>
                        Name 5 family members.
                      </li>
                      <li>
                        Explain how family members take care of one another.
                      </li>
                      <li>
                        Do the following tasks during 1 week:
                        <ol>
                          <li>
                            Help to wash the dishes.
                          </li>
                          <li>
                            Put away or hang your clothes.
                          </li>
                          <li>
                            Help prepare a snack.
                          </li>
                        </ol>
                      </li>
                      <li>
                        Complete the honor: “Animal Homes.”
                      </li>
                    </ol>
                  </div>
                  
                  <div>
                    <h3 class="mobile:text-center mobile:text-xl">
                      <strong>
                        MY WORLD
                      </strong>
                    </h3>
                    <ol class="pl-5" start="21">
                      <li>
                        Know the primary and secondary colors.
                      </li>
                      <li>
                        Talk about how we can help others.
                      </li>
                      <li>
                        Prepare a food or fruit basket and give it to an elderly person.
                      </li>
                      <li>
                        Listen to the story of how David and Jonathan were friends, and do a drawing of
                        what you learned.
                      </li>
                      <li>
                        Make a book about your friends and you.
                      </li>
                      <li>
                        Complete the honor: “Crayons and Markers.”
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div id="curriculum-tab-2">
            <div class="pt-22 mobile:pt-12">
              <h3 class="mb-6 mobile:text-center">
                <strong>
                  Requirements
                </strong>
              </h3>
              <div class="-mx-9 mb-13 flex flex-wrap desktop_medium:-mx-4 tablet:mb-6">
                <div class="mb-12 w-1/4 px-9 text-center desktop_medium:px-4 tablet:w-1/2 mobile-small:w-full">
                  <img class="mb-3 inline-block" src="{{ asset('images/ministries/insignias/squirrels/little-lambs.png') }}"
                    alt="little lambs">
                </div>
              </div>
              <div class="-mx-12 mb-24 flex flex-wrap desktop_medium:-mx-6 tablet:mb-11 mobile:mb-0">
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  
                  <div>
                    <h3 class="mobile:text-center mobile:text-xl">
                      <strong>
                        MY CLUB
                      </strong>
                    </h3>
                    <ol class="mb-9 pl-5">
                      <li>
                        Be 4 years old.
                      </li>
                      <li>
                        Recall the Pledge.
                      </li>
                      <li>
                        Learn the Law.
                      </li>
                      <li>
                        Learn the song “Soy un Cachorro” and recognize the “Cachorros” uniform
                      </li>
                      <li>
                        Have a basic knowledge of lambs and do an arts and crafts project to demonstrate
                        what you know.
                      </li>
                      <li>
                        Complete the honor: “Politeness Fun”
                      </li>
                    </ol>
                  </div>
                  
                  <div>
                    <h3 class="mobile:text-center mobile:text-xl">
                      <strong>
                        MY GOD
                      </strong>
                    </h3>
                    <ol class="mb-9 pl-5" start="7">
                      <li>
                        Understand Jesus’ plan of salvation for children and learn John 3: 16.
                      </li>
                      <li>
                        Compare God’s love for His children with the “good Shepherd” by learning Psalm
                        23: 1.
                      </li>
                      <li>
                        Memorize and understand the fourth commandment (Exodus 20: 8, 9 and 10 first
                        part).
                      </li>
                      <li>
                        Recognize the Lord’s Prayer and learn about prayer.
                      </li>
                      <li>
                        Pray daily with the whole family for one week.
                      </li>
                      <li>
                        Help the deacon at the church door welcome people during one Sabbath
                      </li>
                    </ol>
                  </div>
                  
                  <div>
                    <h3 class="mobile:text-center mobile:text-xl">
                      <strong>
                        MY LIFE
                      </strong>
                    </h3>
                    <ol class="pl-5" start="13">
                      <li>
                        Learn your personal information: name, address and phone number.
                      </li>
                      <li>
                        Identify the main parts of the body.
                      </li>
                      <li>
                        Learn to do the following things on your own:
                        <ol>
                          <li>
                            Choose the clothes you will wear during 3 days.
                          </li>
                          <li>
                            Get dressed (without help) during one week.
                          </li>
                          <li>
                            Know how to brush your teeth correctly.
                          </li>
                        </ol>
                      </li>
                      <li>
                        Know 3 road safety rules for children.
                      </li>
                      <li>
                        Complete the honor: “Toys”.
                      </li>
                    </ol>
                  </div>
                </div>

                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  
                  <div>
                    <h3 class="mobile:text-center mobile:text-xl">
                      <strong>
                        MY FAMILY
                      </strong>
                    </h3>
                    <ol class="mb-9 pl-5" start="18">
                      <li>
                        Learn about the family and its importance, and be familiar with the fifth
                        commandment.
                      </li>
                      <li>
                        Learn about the house chores and why it is important to help out at home.
                      </li>
                      <li>
                        Do the following tasks during one week:
                        <ol>
                          <li>
                            Organize your toys.
                          </li>
                          <li>
                            Help to do the laundry.
                          </li>
                          <li>
                            Help to sweep or vacuum your room.
                          </li>
                        </ol>
                      </li>
                      <li>
                        Complete the honor: “Helping at Home”.
                      </li>
                    </ol>
                  </div>
                  
                  <div>
                    <h3 class="mobile:text-center mobile:text-xl">
                      <strong>
                        MY WORLD
                      </strong>
                    </h3>
                    <ol class="mb-9 pl-5" start="22">
                      <li>
                        Know the primary and secondary colors and demonstrate your knowledge by doing an
                        experiment or a project about them.
                      </li>
                      <li>
                        Talk about Creation and memorize Genesis 1: 1.
                      </li>
                      <li>
                        Learn about the animals of Creation and make an album of 20 animals.
                      </li>
                      <li>
                        Spend an afternoon in nature and do an arts and crafts project on what you have
                        seen.
                      </li>
                      <li>
                        Visit a person who is sick or elderly and take them a card with a drawing you
                        have done.
                      </li>
                      <li>
                        Complete the honor: “Pets”
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div id="curriculum-tab-3">
            <div class="pt-22 mobile:pt-12">
              <h3 class="mb-6 mobile:text-center">
                <strong>
                  Requirements
                </strong>
              </h3>
              <div class="-mx-9 mb-13 flex flex-wrap desktop_medium:-mx-4 tablet:mb-6">
                <div class="mb-12 w-1/4 px-9 text-center desktop_medium:px-4 tablet:w-1/2 mobile-small:w-full">
                  <img class="mb-3 inline-block" src="{{ asset('images/ministries/insignias/squirrels/Beavers.png') }}"
                    alt="">
                </div>
              </div>
              <div class="-mx-12 mb-24 flex flex-wrap desktop_medium:-mx-6 tablet:mb-11 mobile:mb-0">
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  
                  <div>
                    <h3 class="mobile:text-center mobile:text-xl">
                      <strong>
                        MY CLUB
                      </strong>
                    </h3>
                    <ol class="mb-9 pl-5">
                      <li>
                        Be 5 years old.
                      </li>
                      <li>
                        Know the Pledge and the Law of the “Cachorros” by heart.
                      </li>
                      <li>
                        Know the song “Soy un Cachorro”.
                      </li>
                      <li>
                        Be able to explain the “Cachorros” uniform.
                      </li>
                      <li>
                        Have basic knowledge of beavers and do an arts and crafts project to show what
                        you have learned.
                      </li>
                    </ol>
                  </div>
                  
                  <div>
                    <h3 class="mobile:text-center mobile:text-xl">
                      <strong>
                        MY GOD
                      </strong>
                    </h3>
                    <ol class="mb-9 pl-5" start="6">
                      <li>
                        Be able to say what the Bible is in a simple way, and show three ways of taking
                        care of it.
                      </li>
                      <li>
                        Know Philippians 4: 4 by heart and show that you understand its meaning by doing
                        an arts and crafts activity on the text.
                      </li>
                      <li>
                        Demonstrate that you know and understand the fourth commandment by doing an
                        activity with your achievement class or with your family.
                      </li>
                      <li>
                        Recognize the Lord’s Prayer and be able to say a prayer to Jesus that includes
                        praise, thanksgiving and requests.
                      </li>
                      <li>
                        Actively participate in the Children’s Storytime, a Thirteenth Sabbath
                        Children’s Program or a group devotion time at the Club.
                      </li>
                      <li>
                        Complete the honor: “Friends of the Bible”
                      </li>
                    </ol>
                  </div>
                  
                  <div>
                    <h3 class="mobile:text-center mobile:text-xl">
                      <strong>
                        MY LIFE
                      </strong>
                    </h3>
                    <ol class="pl-5" start="12">
                      <li>
                        Demonstrate in an arts and crafts project that you know your full name, your
                        address and your phone number.
                      </li>
                      <li>
                        Learn to do the following tasks on your own:
                        <ol>
                          <li>
                            Fold or hang your clothes, and put them away correctly during one week.
                          </li>
                          <li>
                            Wash your hands correctly.
                          </li>
                          <li>
                            Comb your hair on your own.
                          </li>
                        </ol>
                      </li>
                      <li>
                        Complete the honor: “Getting to Know my Body”.
                      </li>
                      <li>
                        Do a life-size drawing of a friend’s body.
                      </li>
                      <li>
                        Know at least 6 basic safety rules to be safe when you are out on the street.
                      </li>
                    </ol>
                  </div>
                </div>

                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  
                  <div>
                    <h3 class="mobile:text-center">
                      <strong>
                        MY FAMILY
                      </strong>
                    </h3>
                    <ol class="mb-9 pl-5" start="17">
                      <li>
                        Memorize the fifth commandment and do an arts and crafts project to explain its
                        meaning.
                      </li>
                      <li>
                        Read or listen to Daddy, Mommy or your guardian tell a story about your family.
                        Be able to retell it to your counselor.
                      </li>
                      <li>
                        Participate with the rest of the children in a church program for parents doing
                        at least one of the following:
                        <ol>
                          <li>
                            Singing.
                          </li>
                          <li>
                            Reciting a poem.
                          </li>
                          <li>
                            Being part of a performance.
                          </li>
                        </ol>
                      </li>
                      <li>
                        Do the following tasks at home for at least one month (one per week):
                        <ol>
                          <li>
                            Make your bed.
                          </li>
                          <li>
                            Keep your room organized.
                          </li>
                          <li>
                            Take out the trash.
                          </li>
                        </ol>
                      </li>
                      <li>
                        Have a meal outdoors (in nature) with your family, and suggest at least one game
                        to play together.
                      </li>
                      <li>
                        During family worship time, pray every day for one week for a family member.
                      </li>
                    </ol>
                  </div>
                  
                  <div>
                    <h3 class="mobile:text-center">
                      <strong>
                        MY WORLD
                      </strong>
                    </h3>
                    <ol class="mb-9 pl-5" start="23">
                      <li>
                        Know the story of Creation and what was created each day. Do an arts and crafts
                        project about Creation.
                      </li>
                      <li>
                        Complete the honor: “The World of God”.
                      </li>
                      <li>
                        Memorize the Golden Rule of Matthew 7: 12. Understand its meaning.
                      </li>
                      <li>
                        Make a post card with a Nature motif to give to a sick or elderly person.
                      </li>
                      <li>
                        Complete the honor: “My Friends and Jesus”.
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
      </div>
    </div>
  </div>
</div>

<style>
  .section-curriculum ol {
    list-style-type: auto;
  }

  .section-curriculum ol li::marker {
    font-weight: 900;
    color: rgb(69 205 252 / 1);
  }

  .section-curriculum ol li::before {
    content: none;
  }

  .section-curriculum ol>li>ol {
    list-style-type: lower-alpha;
    margin-left: 1.5rem;
  }

  .section-curriculum ol li {
    padding-left: .5rem;
  }

  .achievement-tabs-nav ul li a {
    border-bottom-width: 2px;
  }
</style>
