@php($tabs = [['id' => 1, 'name' => 'Friends'], ['id' => 2, 'name' => 'Companion'], ['id' => 3, 'name' => 'Explorer'], ['id' => 4, 'name' => 'Ranger'], ['id' => 5, 'name' => 'Voyager'], ['id' => 6, 'name' => 'Guide']])
<section class="bg-secondary pb-30 mobile:pb-20">
  <div class="container-xl desktop_extralarge:pl-[50px] desktop_extralarge:pr-[50px] desktop:px-10 tablet:px-6">
    <div class="rounded-xl bg-white px-24 pb-30 pt-16 desktop_large:px-16 mobile:px-9 mobile:py-9">
      <div class="achievement-tabs-nav">
        <ul>
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
              <h3 class="mb-6">
                <strong>
                  Requirements
                </strong>
              </h3>
              <div class="-mx-9 mb-13 flex flex-wrap desktop_medium:-mx-4 tablet:mb-6">
                <div class="mb-12 w-1/4 px-9 text-center desktop_medium:px-4 tablet:w-1/2 mobile-small:w-full">
                  <img class="mb-3 inline-block" src="{{ asset('images/ministries/insignias/patchfinder/friend.png') }}"
                    alt="">
                  <h6 class="mb-0 inline-block max-w-discription tracking-wide">
                    <strong>
                      Friends
                    </strong>
                  </h6>
                </div>

              </div>
              <div class="-mx-12 mb-24 flex flex-wrap desktop_medium:-mx-6 tablet:mb-11">
                <!-- Columna 1 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>General</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Be 11 years old and/or in grade 6 or its equivalent.</li>
                    <li>Be an active member of the Pathfinder Club.</li>
                    <li>Learn or review the meaning of the Pathfinder Pledge and illustrate its meaning in an interesting
                      way.</li>
                    <li>Read the book The Happy Path or similar book on the Pledge and Law if not previously read.</li>
                    <li>Have a current Book Club Certificate and write at least a paragraph of review on one book of your
                      choice.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Know the composition and proper use of your national flag.</li>
                  </ol>

                  <h3 class="mb-6">
                    <strong>Spiritual Discovery</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Memorize the New Testament books and know the four areas into which the books are grouped.
                      Demonstrate your ability to find any given book.</li>
                    <li>Hold a current memory gem certificate.</li>
                    <li>
                      Choose, in consultation with your leader, one of the following areas:
                      <ol class="mt-2 space-y-2 pl-5">
                        <li>One of Christ's Parables</li>
                        <li>One of Christ's Miracles</li>
                        <li>Sermon on the Mount</li>
                        <li>Second Advent Sermon and show your knowledge of what Christ taught in one of the following ways:
                        </li>
                        <li>Discussion with the leader</li>
                        <li>Group activity</li>
                        <li>Giving a talk</li>
                      </ol>
                    </li>
                    <li>
                      Read the Gospels of Matthew and Mark in any translation. Commit to memory any two of the following:
                      <ol class="mt-2 space-y-2 pl-5">
                        <li>Beatitude (Matthew 3:3-12)</li>
                        <li>Lord's Prayer (Matthew 6:9-13)</li>
                        <li>Christ's Return (Matthew 24:4-7, 11-14)</li>
                        <li>Gospel Commission (Matthew 28:18-20)</li>
                      </ol>
                    </li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Read about Ellen White's first vision and discuss how God uses prophets to present His message to
                      the church.</li>
                    <li>Complete the crossword puzzle on the first vision of Ellen White.</li>
                  </ol>

                  <h3 class="mb-6">
                    <strong>Serving Others</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>By consultation with your leader, work out ways to spend at least two hours in your community,
                      demonstrating in a consistent manner real companionship to someone else.</li>
                    <li>Spend at least a half day participating in a project that will benefit the community or your church.
                    </li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Participate in an outreach activity and bring a non-SDA friend to participate or observe.</li>
                  </ol>

                  <h3 class="mb-6">
                    <strong>Friendship Development</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Discuss the principle and demonstrate the meaning of respect for people of different cultures and
                      gender.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Discuss and demonstrate respect for your parents/guardian and what they provide for you.</li>
                  </ol>

                  <h3 class="mb-6">
                    <strong>Health and Fitness</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>
                      Complete the following:
                      <ol class="mt-2 space-y-2 pl-5">
                        <li>Discuss the temperance principles in the life of Daniel, or participate in a presentation or
                          role play on Daniel</li>
                        <li>Memorize and explain Daniel 1:8, and either sign the appropriate pledge card or design your own
                          pledge card showing why you choose a life style in harmony with the true principles of temperance.
                        </li>
                      </ol>
                    </li>
                    <li>Learn the principles of a healthful diet and engage in a project preparing a chart of basic food
                      groups.</li>
                    <li>Complete the Beginner's Swimming Honor.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>HIV/AIDS curriculum</li>
                  </ol>
                </div>

                <!-- Columna 7 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Organization and Leadership Development</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Plan and take a three hour or eight-kilometer hike. Plan to complete a requirement under the Nature
                      Study or Outdoor Life sections or a Nature Honor.</li>
                  </ol>
                  <h3 class="mb-6">
                    <strong>Nature Study</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Complete one of the following honors: Cats, Dogs, Mammals, Seeds, Bird Pets.</li>
                    <li>Know different methods of purifying water and demonstrate your ability to build a camp shelter.
                      Consider the significance of Jesus as the water of life and as our refuge place.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>HIV/AIDS curriculum</li>
                  </ol>

                  <h3 class="mb-6">
                    <strong>Lifestyle Enrichment</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Complete one honor in Arts and Crafts.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Complete one honor in Vocational or Outdoor Industries.</li>
                  </ol>

                  <h3 class="mb-6">
                    <strong>Outdoor life</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Know how ropes are made and demonstrate how to care for rope in the correct manner. Tie and know the
                      practical use of the following knots: Overhand, Granny, Square, Slip, Double Bow, Two Half Hitches,
                      Clove Hitch, Bowline.</li>
                    <li>Participate in an overnight campout.</li>
                    <li>Pass a test in general safety.</li>
                    <li>Pitch and strike a tent and make a camp bed.</li>
                    <li>Know ten hiking rules and know what to do when lost.</li>
                    <li>Learn the signs for track and trail. Be able to lay a two-kilometer trail that others can follow and
                      be able to track a two-kilometer trail.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Start a fire with one match, using natural materials, and keep that fire going.</li>
                    <li>Properly use the knife and axe, and know ten safety rules in their use.</li>
                    <li>Tie five speed knots.</li>
                    <li>Demonstrate baking, boiling, and frying camp food.</li>
                  </ol>
                </div>

            

              </div>

            </div>
          </div>

          <div id="curriculum-tab-2">
            <div class="pt-22 mobile:pt-12">
              <h3 class="mb-6">
                <strong>
                  Requirements
                </strong>
              </h3>
              <div class="-mx-9 mb-13 flex flex-wrap desktop_medium:-mx-4 tablet:mb-6">
                <div class="mb-12 w-1/4 px-9 text-center desktop_medium:px-4 tablet:w-1/2 mobile-small:w-full">
                  <img class="mb-3 inline-block" src="{{ asset('images/ministries/insignias/patchfinder/companion.png') }}"
                    alt="">
                  <h6 class="mb-0 inline-block max-w-discription tracking-wide">
                    <strong>
                      Companion
                    </strong>
                  </h6>
                </div>

              </div>
              <div class="-mx-12 mb-24 flex flex-wrap desktop_medium:-mx-6 tablet:mb-11">
                <!-- Columna 1 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>General</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Be 10 years old and/or in Grade 5 or its equivalent.</li>
                    <li>Be an active member of the AJY Society or Pathfinder Club</li>
                    <li>Memorize and explain the Pathfinder Pledge and Law.</li>
                    <li>Read the book The Happy Path (or similar book on the Pledge and Law).</li>
                    <li>Have a current Book Club Certificate.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Know, sing, or play and explain the meaning of the Pathfinder Song.</li>
                  </ol>
                </div>

                <!-- Columna 2 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Spiritual Discovery</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Memorize the Old Testament books of the Bible and know the five areas into which the books are
                      grouped. Demonstrate your ability to find any given book.</li>
                    <li>Have a current memory gem certificate.</li>
                    <li>Know and explain Psalm 23 or Psalm 46.</li>
                    <li>During several worship periods, read with your parents the historical prologue to the book Early
                      Writings and list the main events of the SDA church or fulfill other options as mentioned on page 26.
                    </li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Complete the crossword puzzle based on the prologue to Early Writings.</li>
                    <li>In consultation with your leader, choose one of the following Old Testament characters: Joseph,
                      Jonah, Esther, or Ruth. Discuss with your group Christ's loving care and deliverance as shown in the
                      story.</li>
                  </ol>
                </div>

                <!-- Columna 3 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Serving Others</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>
                      By consultation with your leader, work out ways to spend at least two hours expressing your friendship
                      to someone in need in your community by doing any two of the following:
                      <ol class="mt-2 space-y-2 pl-5">
                        <li>a. Visit someone who needs friendship.</li>
                        <li>b. Help someone in need.</li>
                        <li>c. With the help of others spend a half day on a community, school, or church project.</li>
                      </ol>
                    </li>
                    <li>Prove yourself a good citizen at home and at school.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Prove yourself a good citizen at home and at school.</li>
                  </ol>
                </div>

                <!-- Columna 4 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Friendship Development</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>List ten qualities of being a good friend and discuss four everyday situations where you have
                      practiced the "Golden Rule".</li>
                    <li>Know your national anthem and explain its meaning.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Demonstrate good table manners with a group of persons of various ages.</li>
                  </ol>
                </div>

                <!-- Columna 5 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Health and Fitness</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Memorize and explain 1 Cor. 9:24-27.</li>
                    <li>Discuss with your leader physical fitness and regular exercise as they relate to healthful living.
                    </li>
                    <li>Learn about the detrimental effects of smoking on health and fitness, and write your own pledge of
                      commitment to abstaining from the use of tobacco.</li>
                    <li>Complete the Advanced Beginner's Swimming Honor.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>HIV/AIDS curriculum</li>
                    <li>Attend a Five Day Plan, or view two films on health, or make a poster on smoking or drug abuse, or
                      help prepare a display on tobacco for a show, etc.</li>
                  </ol>
                </div>

                <!-- Columna 6 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Organization and Leadership Development</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Plan and lead a devotional service for your group.</li>
                    <li>Help your unit or club plan a special activity such as a party, hike, or overnight campout.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Participate in a special club event such as an investiture, open house, induction, or Pathfinder
                      Sabbath, and then evaluate the event to determine how it can be improved.</li>
                  </ol>
                </div>

                <!-- Columna 7 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Nature Study</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Participate in nature games or participate in a one hour nature walk.</li>
                    <li>Complete one of the following honors: Amphibians, Birds, Livestock, Poultry, Reptiles, Shells,
                      Trees, or Shrubs.</li>
                    <li>Review the study of creation, and keep a seven day outdoor log of your personal observations from
                      nature in which each day focuses on those parts that were created on that day.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Identify and describe twelve birds in the wild and twelve native trees.</li>
                  </ol>
                </div>

                <!-- Columna 8 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Outdoor life</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Find the eight general directions without the aid of a compass.</li>
                    <li>Participate in a two night campout. Know at least six points relative to the selection of a
                      campsite.</li>
                    <li>Learn or review the Friend knots. Tie and know the practical use of the following knots: Sheet Bend,
                      Sheepshank, Fisherman's Knot, Timber Hitch, Taut Line Hitch. Learn three basic lashings.</li>
                    <li>Pass a test in Companion first aid.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Build five different fires and describe their uses. Discuss the safety rules in lighting fires, or
                      hike eight kilometers and keep a log.</li>
                    <li>Cook a camp meal without utensils.</li>
                    <li>Prepare a knot board with at least fifteen different knots.</li>
                  </ol>
                </div>

                <!-- Columna 9 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Lifestyle Enrichment</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Complete one Honor in Arts and Crafts not previously earned.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Complete one Honor in Household Arts, Health & Science, Vocational, or Outdoor Industries not
                      previously earned.</li>
                  </ol>
                </div>
              </div>

            </div>
          </div>

          <div id="curriculum-tab-3">
            <div class="pt-22 mobile:pt-12">
              <h3 class="mb-6">
                <strong>
                  Requirements
                </strong>
              </h3>
              <div class="-mx-9 mb-13 flex flex-wrap desktop_medium:-mx-4 tablet:mb-6">
                <div class="mb-12 w-1/4 px-9 text-center desktop_medium:px-4 tablet:w-1/2 mobile-small:w-full">
                  <img class="mb-3 inline-block" src="{{ asset('images/ministries/insignias/patchfinder/explorer.png') }}"
                    alt="">
                  <h6 class="mb-0 inline-block max-w-discription tracking-wide">
                    <strong>
                      Explorer
                    </strong>
                  </h6>
                </div>

              </div>
              <div class="-mx-12 mb-24 flex flex-wrap desktop_medium:-mx-6 tablet:mb-11">
                <!-- Columna 1 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>General</strong>
                  </h3>

                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Be 12 years old and/or in Grade 7 or its equivalent.</li>
                    <li>Be an active member of the AJY Society and Pathfinder Club.</li>
                    <li>Learn or review the meaning of the Pathfinder Law and demonstrate your understanding by
                      participating in one of the following: role play, panel discussion, essay, or prepare a project of
                      your choice.</li>
                    <li>Read the book The Happy Path if not previously read.</li>
                    <li>Have a current Book Club Certificate and write at least a paragraph of review on each book.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Know the composition and proper use of the Pathfinder flag and Unit Guidon.</li>
                  </ol>
                </div>

                <!-- Columna 2 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Spiritual Discovery</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Become familiar with the use of a concordance.</li>
                    <li>Hold a current memory gem certificate.</li>
                    <li>Read the gospels Luke and John in any translation, and discuss in your group any three of the
                      following:

                      <ol class="mt-2 space-y-2 pl-5">
                        <li>a. Luke 4:16-19 The Scripture Reading</li>
                        <li>b. Luke 11:9-13 Ask, Seek, Knock</li>
                        <li>c. Luke 21:25-28 Signs of Second Coming</li>
                        <li>d. John 13:12-17 Humility</li>
                        <li>e. John 14: 1-3 Lord’s Promise</li>
                        <li>f. John 15:5-8 Vine and Branches</li>
                      </ol>
                    </li>
                    <li>In consultation with your leader, choose one of the following areas:

                      <ol class="mt-2 space-y-2 pl-5">
                        <li> a. John 3 Nicodemus</li>
                        <li> b. John 4 The Woman at the Well</li>
                        <li>c. Luke 15 The Prodigal Son</li>
                        <li>d. Luke 10 The Good Samaritan</li>
                        <li>e. Luke 19 Zacchaeus</li>

                      </ol>
                    </li>
                    <li>Share your understanding of how Jesus saves individuals by using one of the following methods:

                      <ol class="mt-2 space-y-2 pl-5">
                        <li> a. Group discussion with your leader.</li>
                        <li> b. Giving a talk at AJY’s.</li>
                        <li>c. Writing an essay.</li>
                        <li> d. Making a series of pictures, charts, or models.</li>
                        <li> e. Writing a poem or song.</li>

                      </ol>
                    </li>
                    <li>Memorize and explain Proverbs 20: 1 and Proverbs 23:29-32.
                    </li>

                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Read about J. N. Andrews. Discuss the importance of mission service to the church and why Christ
                      gave the Great Commission (Matthew 28: 18-20).</li>
                    <li>Complete the map work on missionaries and places of service.</li>
                  </ol>
                </div>

                <!-- Columna 3 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Serving Others</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>
                      Be familiar with the community services in your area and give assistance to at least one.
                    </li>
                    <li> Participate in at least 3 church programs.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Enroll a new member in Sabbath school, Pathfinders, or Bible correspondence course.</li>
                  </ol>
                </div>

                <!-- Columna 4 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Friendship Development</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Participate in a panel discussion or skit or peer pressure and its role in your decision making.
                    </li>
                    <li>Tour your municipal offices or have a city official visit your group and then explain five ways you
                      can cooperate with them.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Earn one of the following honors:
                      <ol class="mt-2 space-y-2 pl-5">
                        <li> a. Christian Grooming and Manners</li>
                        <li> b. Family Life</li>

                      </ol>

                    </li>
                  </ol>
                </div>

                <!-- Columna 5 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Health and Fitness</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Complete one of the following requirements:

                      <ol class="mt-2 space-y-2 pl-5">
                        <li> Participate in a group discussion on the physical effects of drugs and alcohol on the body.
                        </li>
                        <li> View an audio/visual on alcohol or other drugs, and discuss the effects on the human body.</li>

                      </ol>

                    </li>
                    <li>Peer pressure discussion.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>

                  <ol class="space-y-2 pl-5">
                    <li>Participate in a sixteen-kilometer hike and make a list of clothing to be worn.</li>
                    <li>Peer Pressure and AIDS Awareness.</li>
                  </ol>
                </div>

                <!-- Columna 6 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Organization and Leadership Development</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Plan and lead a devotional service for your group.</li>
                    <li>Help your unit or club plan a special activity such as a party, hike, or overnight campout.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Participate in a special club event such as an investiture, open house, induction, Pathfinder
                      Sabbath, etc. and participate in the evaluation of the event afterwards along with the Companion
                      Class.</li>
                  </ol>
                </div>

                <!-- Columna 7 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Nature Study</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>If you live in the Northern Hemisphere, be able to identify the North Star, Orion, Pleiades, and two
                      planets. If you live in the Southern Hemisphere, identify Achernar, the Southern Cross, Centaurus, and
                      Orion. Know the spiritual significance of Orion as told in Early Writings.</li>
                    <li>Complete one of the following honors: Animal Tracking, Cacti, Flowers, Stars, or Weather.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Identify six tracks of animals or birds. Make a plaster cast of three tracks.</li>
                  </ol>
                </div>

                <!-- Columna 8 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Outdoor life</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Participate in a two-night campout. Describe six points of a good campsite. Plan and cook two meals.
                    </li>
                    <li>Pass a test in Explorer first aid.</li>
                    <li>Explain what a topographical map is, what you can expect to find on it, and its uses. Identify at
                      least twenty signs and symbols used on topographic maps.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Review the basic lashings and build one article of camp furniture.</li>
                    <li>Plan a menu for a three-day camping trip for four people using at least three different dehydrated
                      foods.</li>
                    <li>Be able to send and receive the semaphore alphabet, OR Be able to send and receive the international
                      Morse code by wigwag, OR Know the alphabet in sign language for the deaf, OR Have a basic knowledge of
                      procedures of two-way radio communication.</li>
                  </ol>
                </div>

                <!-- Columna 9 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Lifestyle Enrichment</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Complete one honor in Household Arts or Arts and Crafts not previously earned.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Complete one honor in Outreach Ministry, Health & Science, Vocational, or Outdoor Industries not
                      previously earned.</li>
                  </ol>
                </div>
              </div>

            </div>
          </div>

          <div id="curriculum-tab-4">
            <div class="pt-22 mobile:pt-12">
              <h3 class="mb-6">
                <strong>
                  Requirements
                </strong>
              </h3>
              <div class="-mx-9 mb-13 flex flex-wrap desktop_medium:-mx-4 tablet:mb-6">
                <div class="mb-12 w-1/4 px-9 text-center desktop_medium:px-4 tablet:w-1/2 mobile-small:w-full">
                  <img class="mb-3 inline-block" src="{{ asset('images/ministries/insignias/patchfinder/ranger.png') }}"
                    alt="">
                  <h6 class="mb-0 inline-block max-w-discription tracking-wide">
                    <strong>
                      Ranger
                    </strong>
                  </h6>
                </div>

              </div>
              <div class="-mx-12 mb-24 flex flex-wrap desktop_medium:-mx-6 tablet:mb-11">
                <!-- Columna 1 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>General</strong>
                  </h3>

                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Be a teenager 13 years of age and/or in Grade 8 or its equivalent.</li>
                    <li>Memorize and understand the Adventist Youth Aim and Motto.</li>
                    <li>Be an active member of the Pathfinder Club.</li>
                    <li>Select and read three books of your choice from the Teen Book Club List.</li>

                  </ol>

                </div>

                <!-- Columna 2 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Spiritual Discovery</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>1. Discover in group discussion:
                      <ol class="mt-2 space-y-2 pl-5">
                        <li>a. What Christianity is.</li>
                        <li>b. The marks of a true disciple.</li>
                        <li>c. The forces involved in becoming a Christian.</li>

                      </ol>
                    </li>
                    <li>Participate in a Bible marking program on the inspiration of the Bible.</li>
                    <li>Enroll at least three people in a Bible Correspondence Course.</li>
                    <li>Have a current Memory Gem Certificate.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Complete the Christian Citizenship Honor if not previously done.</li>
                  </ol>
                </div>

                <!-- Columna 3 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Serving Others</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>
                      Under the direction of your leader, participate at least once in two different types of outreach
                      programs.
                    </li>
                    <li>With the help of a friend, spend a full day (at least eight hours) working on a project for your
                      church, school, or community.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Conduct two Bible studies with non-Seventh-day Adventists.</li>
                  </ol>
                </div>

                <!-- Columna 4 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Friendship Development</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>In group discussion and by personal inquiry, examine your attitudes to two of the following
                      topics:
                      <ol class="mt-2 space-y-2 pl-5">
                        <li>a. Self-Confidence</li>
                        <li> b. Friendship </li>
                        <li> c. The Social Graces</li>
                        <li> d. Will Power</li>

                      </ol>
                    </li>

                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Role-play the story of the Good Samaritan and think of ways to serve three neighbors, and then do
                      so.

                    </li>
                  </ol>
                </div>

                <!-- Columna 5 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Health and Fitness</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Participate in one of the following:

                      <ol class="mt-2 space-y-2 pl-5">
                        <li>Discuss the principles of physical fitness. Provide an outline of your daily exercise program.
                          Write out and sign a personal pledge of commitment to a regular exercise program.
                        </li>
                        <li> Discuss the natural advantages of living the Adventist Christian lifestyle in accordance with
                          biblical principles.</li>
                      </ol>
                    </li>

                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>

                  <ol class="space-y-2 pl-5">
                    <li>Participate in one of the following activities:
                      <ol class="mt-2 space-y-2 pl-5">
                        <li>a. Hike 15km and keep a log.
                        </li>
                        <li>b. Ride a horse 15 km.</li>
                        <li>c. Go on a one day canoe trip.</li>
                        <li>d. Cycle 80 km.</li>
                        <li>e. Swim 1 km.</li>
                      </ol>

                    </li>
                    <li>Discuss the concept, types, and purpose of dating.</li>
                  </ol>
                </div>

                <!-- Columna 6 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Organization and Leadership Development</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Attend at least one church business meeting. Prepare a brief report for discussion in your group.
                    </li>
                    <li>With your group, make plans for a social activity at least once a quarter.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>1. Complete requirements 3 and 6 of the Drilling and Marching Honor if not previously done.</li>
                  </ol>
                </div>

                <!-- Columna 7 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Nature Study</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Review the story of the flood and study at least three different fossils; explain their origin and
                      relate them to breaking God’s Law.</li>
                    <li>Complete a nature honor not previously earned.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Be able to identify through photographs, sketches, pictures, or real life one of the following
                      categories: 25 tree leaves; 25 rocks and minerals; 25 wild flowers; 25 butterflies and moths; 25
                      shells.</li>
                  </ol>
                </div>

                <!-- Columna 8 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Outdoor life</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Build and demonstrate the use of a reflector oven by cooking something.
                    </li>
                    <li>Participate in a two-night campout. Be able to pack a pack or ruck sack, including personal gear and
                      food sufficient for your participation in a two-night campout.</li>
                    <li>Pass a test in Ranger First Aid.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Complete the Orienteering Honor..</li>
                    <li>Be able to light a fire on a rainy day or in the snow. Know where to get the dry material to keep it
                      going. Demonstrate ability to properly tighten and replace an axe handle.</li>
                    <li>Complete one of the following requirements:

                      <ol class="mt-2 space-y-2 pl-5">
                        <li>a. Know on sight, prepare, and eat ten varieties of wild plant foods.
                        </li>
                        <li>b. Be able to read and receive 35 letters a minute by semaphore code.

                        </li>
                        <li> c. Be able to send and receive 15 letters a minute by wigwag, using the international code.
                        </li>
                        <li> d. Be able to send and receive Matthew 24 in sign language for the deaf.
                        </li>
                        <li> e. Take part in a simple emergency search and rescue operation using two way radios.</li>
                      </ol>
                    </li>
                  </ol>
                </div>

                <!-- Columna 9 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Lifestyle Enrichment</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Complete one honor in Outreach Ministry, Vocational, or Outdoor Industries not previously earned.
                    </li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Complete one honor in Recreation or Arts and Crafts not previously earned.</li>
                  </ol>
                </div>
              </div>

            </div>
          </div>

          <div id="curriculum-tab-5">
            <div class="pt-22 mobile:pt-12">
              <h3 class="mb-6">
                <strong>
                  Requirements
                </strong>
              </h3>
              <div class="-mx-9 mb-13 flex flex-wrap desktop_medium:-mx-4 tablet:mb-6">
                <div class="mb-12 w-1/4 px-9 text-center desktop_medium:px-4 tablet:w-1/2 mobile-small:w-full">
                  <img class="mb-3 inline-block" src="{{ asset('images/ministries/insignias/patchfinder/voyager.png') }}"
                    alt="">
                  <h6 class="mb-0 inline-block max-w-discription tracking-wide">
                    <strong>
                      Voyager
                    </strong>
                  </h6>
                </div>

              </div>
              <div class="-mx-12 mb-24 flex flex-wrap desktop_medium:-mx-6 tablet:mb-11">
                <!-- Columna 1 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>General</strong>
                  </h3>

                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Be a teenager 14 years of age, and/or in grade 9 or its equivalent.</li>
                    <li>Through memorization and discussion, explain the meaning of the Adventist Youth Pledge.</li>
                    <li>Be an active member of Pathfinders.</li>
                    <li>Select and read three books of your choice from the Teen Book Club list.</li>

                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Make a written or oral presentation on respect for God’s law and civil authority giving at least
                      ten principles of moral behavior.</li>
                  </ol>
                </div>

                <!-- Columna 2 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Spiritual Discovery</strong>
                  </h3>

                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Study the personal work of the Holy Spirit as it relates to mankind, and discuss His involvement in
                      spiritual growth.
                    </li>
                    <li>By study and group discussion, increase your knowledge of the last-day events that lead up to the
                      Second Advent.</li>
                    <li>Through study and discussion of Bible evidence, discover the true meaning of Sabbath keeping.</li>
                    <li>Have a current Memory Gem Certificate.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Read the books of Proverbs, Habakkuk, Isaiah, Malachi, and Jeremiah or complete the Junior Bible
                      Year reading program.</li>
                  </ol>
                </div>

                <!-- Columna 3 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Serving Others</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>
                      As a group or individually, invite a friend to at least one of your church or conference teen/youth
                      fellowship activities.
                    </li>
                    <li>As a group or individually, help organize and participate in a project of service to others.</li>
                    <li> Discuss how a Christian Adventist youth relates to people in everyday situations, contacts, and
                      associations.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Spend at least two hours with your pastor, church elder, or deacon, observing them in their
                      pastoral/case ministry.</li>
                  </ol>
                </div>

                <!-- Columna 4 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Friendship Development</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>In group discussion and by personal inquiry, examine your attitudes toward two of the following
                      topics:
                      <ol class="mt-2 space-y-2 pl-5">
                        <li>a. Self-Concept</li>
                        <li> b. Human Relationships - Parents, Family, and Others </li>
                        <li> c. Earning and Spending Money</li>
                        <li> d. Peer Pressure</li>

                      </ol>
                    </li>
                    <li>
                      List and discuss the needs of the handicapped and help plan and participate in a party for them.
                    </li>

                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Visit an institute for the physically or mentally challenged and present a report on the visit.
                    </li>
                  </ol>
                </div>

                <!-- Columna 5 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Health and Fitness</strong>
                  </h3>

                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Choose and complete any two requirements from the Temperance Honor.
                    </li>
                    <li>
                      Organize a health party. Include health principles, talks, displays, etc.
                    </li>

                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>

                  <ol class="space-y-2 pl-5">
                    <li>Study the effective refusal technique of Joseph and explain why it is important to use it today.
                    </li>

                  </ol>
                </div>

                <!-- Columna 6 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Organization and Leadership Development</strong>
                  </h3>

                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Discuss and prepare a flow chart on local church organization and list the departmental functions.
                    </li>
                    <li>Participate in local church programs on two occasions each, in two departments of the church.</li>
                    <li>
                      Fulfill Requirements 3, 5, and 6 of the Stewardship Honor.
                    </li>
                    <li>
                      Complete the Drilling and Marching Honor.
                    </li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Complete the Junior Youth Witnessing Honor.</li>
                  </ol>
                </div>

                <!-- Columna 7 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Nature Study</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Review the story of Nicodemus and relate it to the life cycle of the butterfly, or draw a life-cycle
                      chart of the caterpillar, giving the spiritual significance.</li>
                    <li>Complete a Nature Honor not previously earned.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Plan a list of at least five nature related activities that may be used for Sabbath afternoons.</li>
                  </ol>
                </div>

                <!-- Columna 8 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Outdoor life</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>With a party of not less than four, including an experienced adult counselor, hike 25 km. in a rural
                      wilderness area, including one night in the open or in tents. The expedition planning should be a
                      joint effort of the party and all food needed should be carried. From notes taken, participate in a
                      group discussion, led by your counselor, on the terrain, flora, and fauna, as observed on the hike.
                    </li>
                    <li>Complete one Recreational Honor not previously earned.</li>
                    <li>Pass a test in Voyager First Aid.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>1. Design and build five articles of camp furniture and design an entrance for your club camp that
                      could be used for a camporee.</li>

                  </ol>
                </div>

                <!-- Columna 9 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Lifestyle Enrichment</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Complete one honor in Outreach Ministries, Health and Science, Household Arts, Outdoor Industry, or
                      Vocational categories not previously earned.
                    </li>
                  </ol>

                </div>
              </div>

            </div>
          </div>

          <div id="curriculum-tab-6">
            <div class="pt-22 mobile:pt-12">
              <h3 class="mb-6">
                <strong>
                  Requirements
                </strong>
              </h3>
              <div class="-mx-9 mb-13 flex flex-wrap desktop_medium:-mx-4 tablet:mb-6">
                <div class="mb-12 w-1/4 px-9 text-center desktop_medium:px-4 tablet:w-1/2 mobile-small:w-full">
                  <img class="mb-3 inline-block" src="{{ asset('images/ministries/insignias/patchfinder/guide.png') }}"
                    alt="">
                  <h6 class="mb-0 inline-block max-w-discription tracking-wide">
                    <strong>
                      Guide
                    </strong>
                  </h6>
                </div>

              </div>
              <div class="-mx-12 mb-24 flex flex-wrap desktop_medium:-mx-6 tablet:mb-11">
                <!-- Columna 1 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>General</strong>
                  </h3>

                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Be a teenager 15 years of age, and/or in Grade 10 or its equivalent.
                    </li>
                    <li>
                      Know and understand the AY Legion of Honor.

                    </li>
                    <li>
                      Be an active member of Pathfinder Club.

                    </li>
                    <li>
                      Select and read one book of your choice from the Teen Book Club list, plus a book on local church
                      history (select book for your division or country).
                    </li>

                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Complete the Stewardship Honor.</li>
                  </ol>
                </div>

                <!-- Columna 2 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Spiritual Discovery</strong>
                  </h3>

                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Discuss how the Christian can possess the gifts of the Spirit as described by Paul in his letter to
                      the Galatians.
                    </li>
                    <li>Study and discuss how the Old Testament sanctuary service points to the cross and the personal
                      ministry of Jesus.</li>
                    <li>Read and outline three stories of Adventist pioneers. Tell these stories during a Pathfinder Club,
                      AY, or Sabbath school worship time.</li>
                    <li>Have a current Memory Gem Certificate.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Read Steps to Christ and write a one page report/essay.</li>
                  </ol>
                </div>

                <!-- Columna 3 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Community Outreach</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>
                      1. As a group (or individually) help organize and participate in one of the following:
                      <ol class="mt-2 space-y-2 pl-5">
                        <li>a. Make a friendship visit with a shut-in person.</li>
                        <li> b. Adopt a person or family in need and assist them.</li>
                        <li>c. Any other outreach of your choice approved by your leader.</li>

                      </ol>
                    </li>
                    <li>Participate in a discussion on witnessing to other teenagers and put some of the guidelines into
                      practice in a real situation.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Complete one of the following:

                      <ol class="mt-2 space-y-2 pl-5">
                        <li>a. Bring two friends to at least two meetings sponsored by your church.</li>
                        <li> b. Help plan and participate in at least four meetings of youth evangelism or similar events.
                        </li>

                      </ol>
                    </li>
                  </ol>
                </div>

                <!-- Columna 4 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Friendship Development</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>In group discussion and by personal inquiry, examine your attitudes to two of the following
                      topics:
                      <ol class="mt-2 space-y-2 pl-5">
                        <li>a. Choosing Your Career</li>
                        <li>b. Moral Behavior</li>
                        <li> c. Sex and Dating</li>
                        <li> d. Choosing Your Life Partner</li>

                      </ol>
                    </li>

                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Write (750 words minimum) or give an oral presentation (10 minutes minimum) on the subject of “How
                      to make and keep friends.”
                    </li>
                  </ol>
                </div>

                <!-- Columna 5 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Health and Fitness</strong>
                  </h3>

                  <ol class="mb-8 space-y-2 pl-5">
                    <li>
                      Make a presentation to elementary students on the subject of the laws of good health.
                    </li>
                    <li>
                      Complete one of the following activities:
                      <ol class="mt-2 space-y-2 pl-5">
                        <li>a. Write a poem or article for possible submission to one of the health/temperance journals of
                          the church.</li>
                        <li>b. Individually or as a group, organize and participate in a “Fun Run” or similar activity.
                          Discuss and record your physical training program in preparation for this event.</li>
                        <li>c. Read pages 102-125 in the book Temperance by Ellen White, and pass the true/false quiz.</li>

                      </ol>
                    </li>
                    <li>
                      Complete the Nutrition Honor or lead a group through the Physical Fitness Honor.
                    </li>

                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>

                  <ol class="space-y-2 pl-5">
                    <li>
                      Seeking God’s plan regarding sexual behavior – AIDS & STD’s.
                    </li>

                  </ol>
                </div>

                <!-- Columna 6 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Organization and Leadership Development</strong>
                  </h3>

                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Following discussion, prepare a flow chart on denominational organization, with special details for
                      your division.
                    </li>
                    <li>Attend a conference sponsored Basic Pathfinder Staff Training Course.</li>
                    <li>
                      Plan and teach at least two requirements of any Pathfinder honor for a group of Junior Pathfinders.
                    </li>
                  </ol>

                </div>

                <!-- Columna 7 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Nature Study</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Read the story of Jesus’ childhood in Desire of Ages chapter 7 and relate it to the place of nature
                      study in His education and ministry by presenting original nature lessons (parables) drawn from your
                      study and observations to an audience. </li>
                    <li>Complete one of the following honors:
                      <ol class="mt-2 space-y-2 pl-5">
                        <li>a. Ecology</li>
                        <li>b. Environmental Conservation</li>

                      </ol>
                    </li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Plan a list of at least five nature related activities that may be used for Sabbath afternoons.</li>
                  </ol>
                </div>

                <!-- Columna 8 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Outdoor LIVING</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Go on a two-night pack camp. Discuss the equipment to be taken.
                    </li>
                    <li>Plan and cook in a satisfactory manner a three-course meal on an open fire.</li>
                    <li>Complete an object of lashings or rope work.</li>
                    <li>Complete one honor not previously earned that can count towards the Aquatic, Sportsman, Recreation,
                      or Wilderness Master.</li>
                  </ol>

                  <h5 class="mb-3 uppercase text-primary">
                    <strong>Advanced</strong>
                  </h5>
                  <ol class="space-y-2 pl-5">
                    <li>Complete the Wilderness Master.</li>

                  </ol>
                </div>

                <!-- Columna 9 -->
                <div class="w-1/2 px-12 desktop_medium:px-6 tablet:mb-9 tablet:w-full">
                  <h3 class="mb-6">
                    <strong>Lifestyle Enrichment</strong>
                  </h3>
                  <ol class="mb-8 space-y-2 pl-5">
                    <li>Complete an honor in Outreach Ministries, Outdoor Industries, Vocational, Health and Science, or
                      Household Arts not previously completed.
                    </li>
                  </ol>

                </div>
              </div>

            </div>
          </div>
        
      </div>
    </div>
  </div>
</section>

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

  @media(max-width: 767px) {
    .achievement-tabs-nav ul {
      justify-content: space-between;
    }
  }
</style>
