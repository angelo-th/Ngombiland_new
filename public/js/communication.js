
        function communicationApp() {
            return {
                user: {
                    name: "Jean Nkomo",
                    avatar: "https://via.placeholder.com/40"
                },
                activeTab: 'chat',
                showNotifications: false,
                unreadNotifications: 3,
                openedFAQ: null,
                newMessage: '',
                activeConversation: 1,
                currentChat: {
                    id: 1,
                    name: "Support NGOMBILAND",
                    avatar: "https://via.placeholder.com/40",
                    online: true,
                    isTyping: false,
                    messages: [
                        {
                            id: 1,
                            sender: "support",
                            text: "Bonjour Jean, comment pouvons-nous vous aider aujourd'hui?",
                            time: "10:30 AM"
                        },
                        {
                            id: 2,
                            sender: "user",
                            text: "J'ai une question concernant le paiement des loyers de mon investissement",
                            time: "10:32 AM"
                        },
                        {
                            id: 3,
                            sender: "support",
                            text: "Je peux certainement vous aider avec ça. Pouvez-vous me préciser le nom du projet concerné?",
                            time: "10:33 AM"
                        }
                    ]
                },
                conversations: [
                    {
                        id: 1,
                        name: "Support NGOMBILAND",
                        avatar: "https://via.placeholder.com/40",
                        lastMessage: "Je peux certainement vous aider avec ça...",
                        unread: 0,
                        online: true
                    },
                    {
                        id: 2,
                        name: "Paul Mbarga",
                        avatar: "https://via.placeholder.com/40",
                        lastMessage: "Merci pour l'information!",
                        unread: 1,
                        online: false
                    },
                    {
                        id: 3,
                        name: "Marie Fouda",
                        avatar: "https://via.placeholder.com/40",
                        lastMessage: "Quand sera le prochain paiement?",
                        unread: 0,
                        online: true
                    }
                ],
                faqs: [
                    {
                        id: 1,
                        question: "Comment fonctionnent les paiements de loyers?",
                        answer: "Les loyers sont distribués mensuellement, avec 70% alloués aux investisseurs et 30% pour les frais de gestion et réserves.",
                        link: "/faq/paiements-loyers"
                    },
                    {
                        id: 2,
                        question: "Puis-je revendre mes parts d'investissement?",
                        answer: "Oui, notre marketplace secondaire permet d'acheter et vendre des parts entre investisseurs à tout moment.",
                        link: "/faq/marketplace-secondaire"
                    }
                ],
                guides: [
                    {
                        id: 1,
                        title: "Guide d'Investissement",
                        description: "Apprenez comment investir dans des projets immobiliers sur NGOMBILAND",
                        image: "https://via.placeholder.com/400x200",
                        link: "/guides/investissement"
                    },
                    {
                        id: 2,
                        title: "Vendre un Bien Immobilier",
                        description: "Processus complet pour proposer un bien sur notre plateforme",
                        image: "https://via.placeholder.com/400x200",
                        link: "/guides/vendre-bien"
                    }
                ],
                notifications: [
                    {
                        id: 1,
                        title: "Paiement Reçu",
                        message: "Votre loyer pour Résidence Les Palmiers a été distribué (15,250 FCFA)",
                        type: "success",
                        time: "Il y a 2 heures",
                        read: false
                    },
                    {
                        id: 2,
                        title: "Nouveau Message",
                        message: "Vous avez reçu un message de Paul Mbarga",
                        type: "info",
                        time: "Hier",
                        read: true
                    }
                ],
                
                // Methods
                selectConversation(id) {
                    this.activeConversation = id;
                    this.activeTab = 'chat';
                    // In a real app, we would load the conversation from API
                    this.currentChat = this.conversations.find(c => c.id === id);
                    this.currentChat.messages = [
                        {
                            id: 1,
                            sender: id === 1 ? "support" : "other",
                            text: id === 1 ? "Bonjour Jean, comment pouvons-nous vous aider aujourd'hui?" : "Salut Jean, comment ça va?",
                            time: "10:30 AM"
                        }
                    ];
                    this.currentChat.unread = 0;
                },
                
                startNewChat(type) {
                    this.activeTab = 'chat';
                    if (type === 'support') {
                        this.currentChat = {
                            id: 0,
                            name: "Support NGOMBILAND",
                            avatar: "https://via.placeholder.com/40",
                            online: true,
                            isTyping: false,
                            messages: []
                        };
                    }
                },
                
                sendMessage() {
                    if (!this.newMessage.trim()) return;
                    
                    // Add user message
                    this.currentChat.messages.push({
                        id: this.currentChat.messages.length + 1,
                        sender: "user",
                        text: this.newMessage,
                        time: new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
                    });
                    
                    // Simulate reply after 1 second
                    setTimeout(() => {
                        this.currentChat.isTyping = true;
                        
                        setTimeout(() => {
                            this.currentChat.isTyping = false;
                            this.currentChat.messages.push({
                                id: this.currentChat.messages.length + 1,
                                sender: this.activeConversation === 1 ? "support" : "other",
                                text: this.activeConversation === 1 ? 
                                    "Merci pour votre message. Notre équipe vous répondra sous peu." : 
                                    "Je viens de voir votre message, je vous réponds bientôt!",
                                time: new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
                            });
                            
                            // Scroll to bottom
                            this.$nextTick(() => {
                                this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
                            });
                        }, 2000);
                    }, 1000);
                    
                    this.newMessage = '';
                    this.$nextTick(() => {
                        this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
                    });
                },
                
                toggleFAQ(id) {
                    this.openedFAQ = this.openedFAQ === id ? null : id;
                },
                
                openNotifications() {
                    this.showNotifications = true;
                    this.unreadNotifications = 0;
                },
                
                markAsRead(id) {
                    const notification = this.notifications.find(n => n.id === id);
                    if (notification) notification.read = true;
                }
            }
        }
    